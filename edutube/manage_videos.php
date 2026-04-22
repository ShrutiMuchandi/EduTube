<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Videos</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="./css/style.css"> 
</head>

<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">🎬 <span>Edu</span>Tube</div>
</nav>

<div class="tutorials-wrap">

  <!-- HEADER -->
  <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h1>Manage Tutorials</h1>
      <div class="accent-line"></div>
      <p>View, edit and delete uploaded videos</p>
    </div>

    <!-- Upload Button -->
	<div>
	<a href="manage_masters.php" class="btn btn-primary">⚙ Manage Masters</a>
    <a href="upload.php" class="btn btn-primary">+ Upload Video</a>
	</div>
  </div>

  <!-- FILTER BAR -->
   <div class="filter-bar">
    <div class="search-box">
      <span class="search-icon">🔍</span>
      <input type="text" id="s-search" placeholder="Search by title, subject, keyword…" oninput="filterCards()"/>
    </div>
    <select class="filter-select" id="s-branch" onchange="filterCards()">
      <option value="">All Branches</option>
    </select>
    <select class="filter-select" id="s-sem" onchange="filterCards()">
      <option value="">All Semesters</option>
    </select>
    <select class="filter-select" id="s-curriculum" onchange="filterCards()">
      <option value="">All Curricula</option>
    </select>
    <select class="filter-select" id="s-lecturer" onchange="filterCards()">
      <option value="">All Lecturers</option>
    </select>
  </div>

  <!-- TABLE -->
  
  <div class="table-wrap">
  <div class="table-header">Uploaded Videos</div>

  <table class="data-table">
    <thead>
      <tr>
        <th class="col-title">Title</th>
        <th class="col-branch">Branch</th>
        <th class="col-sem">Sem</th>
        <th class="col-subject">Subject</th>
        <th class="col-lecturer">Lecturer</th>
        <th class="col-views">Views</th>
        <th class="col-actions">Actions</th>
      </tr>
    </thead>

    <tbody id="table-body">
      <!-- JS will fill -->
    </tbody>
  </table>
</div>

  <!-- PAGINATION -->
  <div id="pagination" style="display:flex;justify-content:center;gap:10px;margin-top:20px;"></div>
</div>


<script>
let videos = [];
let dropdownData = {};

let currentPage = 1;
let rowsPerPage = 10;

// ───────── LOAD DATA ─────────
async function loadData(){
  const res = await fetch('api/fetch_videos.php');
  videos = await res.json();

  currentPage = 1;
  paginate(videos); // ✅ IMPORTANT
}

// ───────── RENDER TABLE ─────────
function renderTable(data){
  const tbody = document.getElementById('table-body');
  tbody.innerHTML = '';

  if(data.length === 0){
    tbody.innerHTML = `
      <tr>
        <td colspan="7" style="text-align:center;padding:20px;">
          No data found
        </td>
      </tr>`;
    return;
  }

  data.forEach(v => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${v.video_title}</td>
      <td>${v.branch}</td>
      <td>${v.semester}</td>
      <td>${v.subject_name}</td>
      <td>${v.lecturer || ''}</td>
      <td style="text-align:center;">${v.views_count || 0}</td>
      <td>
        <button class="btn-sm" onclick="viewVideo(${v.id})">View</button>
        <button class="btn-sm" onclick="editVideo(${v.id})">Edit</button>
        <button class="btn-sm" onclick="deleteVideo(${v.id})">Delete</button>
      </td>
    `;

    tbody.appendChild(tr);
  });
}

// ───────── PAGINATION CORE ─────────
function paginate(data){
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;

  const paginatedData = data.slice(start, end);

  renderTable(paginatedData);
  renderPagination(data);
}

// ───────── PAGINATION UI ─────────
function renderPagination(data){
  const container = document.getElementById('pagination');
  if(!container) return; // safety

  container.innerHTML = '';

  const pageCount = Math.ceil(data.length / rowsPerPage);

  // PREV
  const prev = document.createElement('button');
  prev.innerText = "Prev";
  prev.onclick = () => {
    if(currentPage > 1){
      currentPage--;
      paginate(data);
    }
  };
  container.appendChild(prev);

  // PAGE NUMBERS
  for(let i = 1; i <= pageCount; i++){
    const btn = document.createElement('button');
    btn.innerText = i;

    if(i === currentPage){
      btn.style.fontWeight = 'bold';
    }

    btn.onclick = () => {
      currentPage = i;
      paginate(data);
    };

    container.appendChild(btn);
  }

  // NEXT
  const next = document.createElement('button');
  next.innerText = "Next";
  next.onclick = () => {
    if(currentPage < pageCount){
      currentPage++;
      paginate(data);
    }
  };
  container.appendChild(next);
}

// ───────── FILTER ─────────
function filterCards(){
  const q = document.getElementById('s-search').value.toLowerCase();
  const branch = document.getElementById('s-branch').value;
  const sem = document.getElementById('s-sem').value;
  const cu = document.getElementById('s-curriculum').value;
  const lecturer = document.getElementById('s-lecturer').value;

  let filtered = videos.filter(v => {
    const title = (v.video_title || '').toLowerCase();
    const subject = (v.subject_name || '').toLowerCase();

    return (
      (!q || title.includes(q) || subject.includes(q)) &&
      (!branch || v.branch === branch) &&
      (!sem || v.semester == sem) &&
      (!cu || v.curriculum === cu) &&
      (!lecturer || v.lecturer === lecturer)
    );
  });

  currentPage = 1;
  paginate(filtered); // ✅ IMPORTANT
}

// ───────── ACTIONS ─────────
function viewVideo(id){
  window.location.href = "view_video.php?id=" + id;
}

function editVideo(id){
  window.location.href = "edit_video.php?id=" + id;
}

function deleteVideo(id){
  if(confirm("Delete this video?")){
    fetch(`api/delete_video.php?id=${id}`)
      .then(() => loadData());
  }
}

// ───────── DROPDOWNS ─────────
async function loadDropdowns(){
  const res = await fetch('api/fetch_dropdowns.php');
  dropdownData = await res.json();

  fillSelect('s-branch', dropdownData.branches);
  fillSelect('s-sem', dropdownData.semesters);
  fillSelect('s-curriculum', dropdownData.curriculum);
  fillSelect('s-lecturer', dropdownData.lecturers);
}

function fillSelect(id, items){
  const select = document.getElementById(id);
  if(!select) return;

  let label = "Select";

  if(id.includes("branch")) label = "Select Branch";
  else if(id.includes("sem")) label = "Select Semester";
  else if(id.includes("curriculum")) label = "Select Curriculum";
  else if(id.includes("lecturer")) label = "Select Lecturer";

  select.innerHTML = `<option value="">${label}</option>`;

  items.forEach(item => {
    let value = typeof item === 'object' ? item.name : item;
    select.innerHTML += `<option value="${value}">${value}</option>`;
  });
}

// ───────── INIT ─────────
window.onload = () => {
  loadData();
  loadDropdowns();
};
</script>
</body>
</html>
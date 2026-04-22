<!-- ═══════════════ TUTORIALS PAGE ═══════════════ -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EduTube - Tutorials</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="./css/style.css"> 
</head>

<body>

<!-- NAVBAR -->
<nav>
  <div class="nav-logo">🎬 <span>Edu</span>Tube</div>
</nav>

<!-- PASTE TUTORIALS CONTENT HERE -->
<div class="tutorials-wrap">
  <div class="page-header" style="margin-bottom:24px;">
    <h1>Tutorial Library</h1>
    <div class="accent-line"></div>
    <p>Browse, search and watch recorded lectures</p>
  </div>

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
    <div class="sort-group">
      <button class="sort-btn active" id="sort-new" onclick="sortCards('newest')">Newest</button>
      <button class="sort-btn" id="sort-pop" onclick="sortCards('popular')">Most Viewed</button>
      <button class="sort-btn" id="sort-az" onclick="sortCards('az')">A–Z</button>
    </div>
  </div>

  <div class="results-meta" id="results-meta">Showing all tutorials</div>
  <div class="grid" id="cards-grid"></div>
</div>

<!-- VIDEO MODAL -->
<div class="modal-overlay" id="video-modal" onclick="closeModal(event)">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-title" id="modal-title"></div>
        <div class="modal-subtitle" id="modal-subtitle"></div>
      </div>
      <div class="modal-close" onclick="closeVideoModal()">✕</div>
    </div>
    <div class="modal-video" id="modal-video"></div>
    <div class="modal-info" id="modal-info"></div>
  </div>
</div>

<div id="pagination" style="margin-top:30px; text-align:center;"></div>
<!--  JS   -->
<script>
let videos = [];
let editTarget = null;
let currentSort = 'newest';
let dropdownData = {};
let currentPage = 1;
let rowsPerPage = 16;

// ─── HELPERS ───
function ytId(url){
  const m = url.match(/(?:v=|youtu\.be\/|embed\/)([^&?\s]+)/);
  return m ? m[1] : null;
}
function embedUrl(url){
  const id = ytId(url);
  return id ? `https://www.youtube.com/embed/${id}` : '';
}
function thumbUrl(url){
  const id = ytId(url);
  return id ? `https://img.youtube.com/vi/${id}/hqdefault.jpg` : '';
}
/*function initials(name){
  return name.split(' ').map(w=>w[0]).join('').toUpperCase();
}
*/
function initials(name){
  if(!name) return 'NA';
  return name.split(' ').map(w=>w[0]).join('').toUpperCase();
}

// ─── LOAD ───
async function loadVideos(){
  const res = await fetch('api/fetch_videos.php');
  videos = await res.json();

  //renderCards(videos);
  filterCards();
}
//window.onload = loadVideos;
window.onload = () => {
  loadVideos();
  loadDropdowns(); // 🔥 THIS LINE
};


async function loadDropdowns(){
  const res = await fetch('api/fetch_dropdowns.php');
  dropdownData = await res.json();

  fillSelect('s-branch', dropdownData.branches);
  fillSelect('s-sem', dropdownData.semesters);
  fillSelect('s-curriculum', dropdownData.curriculum);
  fillSelect('s-lecturer', dropdownData.lecturers);
}


function f(id){
  return document.getElementById(id).value;
}


// ─── DROPDOWN MENU ───
function toggleMenu(e, el){
  e.stopPropagation();

  document.querySelectorAll('.dropdown-menu').forEach(m => {
    m.classList.remove('open');
  });

  const menu = el.querySelector('.dropdown-menu');
  menu.classList.toggle('open');
}

document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown-menu').forEach(m => {
    m.classList.remove('open');
  });
});



function openVideoModal(v){
  document.getElementById('video-modal').classList.add('open');

  document.getElementById('modal-title').innerText = v.video_title;
  document.getElementById('modal-subtitle').innerText = v.subject_name;

  document.getElementById('modal-video').innerHTML =
    `<iframe src="${embedUrl(v.youtube_url)}" allowfullscreen></iframe>`;

  document.getElementById('modal-info').innerHTML = `
    <div class="info-item">
      <label>Branch</label>
      <p>${v.branch}</p>
    </div>
    <div class="info-item">
      <label>Semester</label>
      <p>${v.semester}</p>
    </div>
    <div class="info-item">
      <label>Lecturer</label>
      <p>${v.lecturer || ''}</p>
    </div>
    <div class="info-item">
      <label>Keywords</label>
      <p>${Array.isArray(v.keywords) ? v.keywords.join(', ') : v.keywords}</p>
    </div>
    <div class="info-item">
      <label>Views</label>
      <p id="modal-views">${v.views_count}</p>
    </div>
  `;

  // Increment views
  fetch(`api/update_views.php?id=${v.id}`)
    .then(res => res.json())
    .then(data => {
      if(data.status === "success"){
        // Update modal views
        document.getElementById('modal-views').innerText = data.views;

        // Update main page card views if it exists
        const span = document.getElementById(`views-${v.id}`);
        if(span) span.textContent = data.views;
      }
    });
}
function closeVideoModal(){
  document.getElementById('video-modal').classList.remove('open');
}

function closeModal(e){
  if(e.target.id === 'video-modal'){
    closeVideoModal();
  }
}



// ─── UI HELPERS ───
function showPage(page){
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + page).classList.add('active');

  document.querySelectorAll('.nav-tab').forEach(b => b.classList.remove('active'));
  event.target.classList.add('active');
}

function showToast(msg, color='#2ecc71'){
  const t = document.getElementById('toast');
  t.innerText = msg;
  t.style.background = color;
  t.classList.add('show');
  setTimeout(()=> t.classList.remove('show'), 2500);
}

function previewYT(){
  const url = document.getElementById('f-yturl').value;
  const id = ytId(url);
  const box = document.getElementById('yt-preview');

  if(id){
    box.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}" allowfullscreen></iframe>`;
  } else {
    box.innerHTML = `<div class="preview-icon">▶</div><span>Invalid YouTube URL</span>`;
  }
}

function resetForm(){
  document.querySelectorAll('input, textarea').forEach(i => i.value='');
  document.querySelectorAll('select').forEach(s => s.selectedIndex=0);
  document.getElementById('yt-preview').innerHTML =
    `<div class="preview-icon">▶</div><span>Paste a YouTube URL to preview</span>`;
}

function filterCards(){
  const q = document.getElementById('s-search').value.toLowerCase();
  const branch = document.getElementById('s-branch').value;
  const sem = document.getElementById('s-sem').value;
  const cu = document.getElementById('s-curriculum').value;
  const lecturer = document.getElementById('s-lecturer').value;

currentPage = 1;

  let filtered = videos.filter(v => {

    const title = (v.video_title || '').toLowerCase();
    const subject = (v.subject_name || '').toLowerCase();

    return (
      (!q || title.includes(q) || subject.includes(q)) &&
      (!branch || v.branch === branch) &&
      (!sem || v.semester === sem) &&
      (!cu || v.curriculum === cu) &&
      (!lecturer || v.lecturer === lecturer)
    );

  });
  
  sortList(filtered);
setupPagination(filtered);

document.getElementById('results-meta').innerHTML =
  `Showing <strong>${filtered.length}</strong> tutorials`;
}

function sortList(list){
  if(currentSort === 'newest'){
    list.sort((a,b)=> 
      new Date(b.created_at || 0) - new Date(a.created_at || 0)
    );
  } 
  else if(currentSort === 'popular'){
    list.sort((a,b)=> (b.views_count || 0) - (a.views_count || 0));
  } 
  else if(currentSort === 'az'){
    list.sort((a,b)=> (a.video_title || '').localeCompare(b.video_title || ''));
  }
}


function sortCards(type){
  currentSort = type;

  // update active button UI
  document.querySelectorAll('.sort-btn').forEach(btn => {
    btn.classList.remove('active');
  });

  if(type === 'newest') document.getElementById('sort-new').classList.add('active');
  if(type === 'popular') document.getElementById('sort-pop').classList.add('active');
  if(type === 'az') document.getElementById('sort-az').classList.add('active');

  // re-run filtering + sorting
  filterCards();
}

// ─── RENDER CARDS ───
function renderCards(data) {
  const grid = document.getElementById('cards-grid');
  grid.innerHTML = '';

  if (data.length === 0) {
    grid.innerHTML = `
      <div class="no-results">
        <div class="icon">🔍</div>
        <h3>No tutorials found</h3>
        <p>Try adjusting filters or search term</p>
      </div>`;
    return;
  }

  data.forEach(v => {
   // const tags = Array.isArray(v.keywords) ? v.keywords : [];
   const tags = Array.isArray(v.keywords)
  ? v.keywords
  : (v.keywords ? v.keywords.split(',') : []);

 // Get branch abbreviation from name
let branchShort = '';

if(v.branch){
  const match = v.branch.match(/\(([^)]+)\)/);

  if(match){
    branchShort = match[1];
  } else {
    branchShort = v.branch
      .split(' ')
      .map(w => w[0])
      .join('')
      .toUpperCase();
  }
}
    // Semester number only
    let semShort = v.semester ? v.semester.replace(/\D/g, '') : '';

    const card = document.createElement('div');
    card.className = 'card';
    card.onclick = () => openVideoModal(v);

    card.innerHTML = `
      <div class="card-thumb">
		<img src="${thumbUrl(v.youtube_url)}" onerror="this.src='fallback.jpg'"/>
        <div class="play-overlay">
          <div class="play-btn">▶</div>
        </div>

        <div class="card-meta-top">
          <span class="chip branch">${branchShort}</span>
          <span class="chip sem">Sem ${semShort}</span>
        </div>
      </div>

      <div class="card-body">
        <div class="card-title">${v.video_title}</div>
        <div class="card-subject">${v.subject_name}</div>
        <div class="card-tags">
          ${tags.map(t => `<div class="tag">${t.trim()}</div>`).join('')}
        </div>
      </div>

      <div class="card-footer">
        <div class="lecturer-info">
          <div class="lecturer-name">${v.lecturer || ''}</div>
        </div>
        <div class="views" id="views-${v.id}">👁 ${v.views_count || 0}</div>
      </div>
    `;

    grid.appendChild(card);
  });
}


function fillSelect(id, items){
  const select = document.getElementById(id);

  if(!select) return; // ✅ FIX (prevents crash)

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


function setupPagination(data){
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  let pageCount = Math.ceil(data.length / rowsPerPage);

  let start = (currentPage - 1) * rowsPerPage;
  let end = start + rowsPerPage;
  let paginatedItems = data.slice(start, end);

  renderCards(paginatedItems);

  // PREV
  let prev = document.createElement('button');
  prev.innerText = 'Prev';
  prev.className = 'sort-btn';
  prev.onclick = () => {
    if(currentPage > 1){
      currentPage--;
      setupPagination(data);
    }
  };
  pagination.appendChild(prev);

  // PAGE NUMBERS
  for(let i = 1; i <= pageCount; i++){
    let btn = document.createElement('button');
    btn.innerText = i;
    btn.className = 'sort-btn';

    if(i === currentPage) btn.classList.add('active');

    btn.onclick = () => {
      currentPage = i;
      setupPagination(data);
    };

    pagination.appendChild(btn);
  }

  // NEXT
  let next = document.createElement('button');
  next.innerText = 'Next';
  next.className = 'sort-btn';
  next.onclick = () => {
    if(currentPage < pageCount){
      currentPage++;
      setupPagination(data);
    }
  };
  pagination.appendChild(next);
}




</script>

</body>
</html>









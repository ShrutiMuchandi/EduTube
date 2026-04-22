<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Masters</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="./css/style.css">
</head>

<body>

<nav>
  <div class="nav-logo">🎬 <span>Edu</span>Tube</div>
  <button onclick="window.location.href='manage_videos.php'" class="back-btn">← Back</button>
</nav>

<div class="tutorials-wrap">

  <div class="page-header">
    <h1>Manage Masters</h1>
    <div class="accent-line"></div>
    <p>Add / Edit / Delete master data</p>
  </div>

  <!-- TYPE SELECT -->
  <div style="margin-bottom:20px;">
    <select id="type" onchange="loadData()" class="filter-select">
      <option value="branches">Branches</option>
      <option value="semesters">Semesters</option>
      <option value="curriculum">Curriculum</option>
      <option value="lecturers">Lecturers</option>
    </select>
  </div>

  <!-- ADD -->
  <div style="display:flex; gap:10px; margin-bottom:20px;">
    <input type="text" id="name" placeholder="Enter value..." class="filter-select">
    <button class="btn btn-primary" onclick="addItem()">+ Add</button>
  </div>

  <!-- TABLE -->
  <table class="data-table">
    <thead>
      <tr>
        <th>Name</th>
        <th width="150">Actions</th>
      </tr>
    </thead>
    <tbody id="table-body"></tbody>
  </table>

</div>

<script>
let currentType = 'branches';

// LOAD DATA
async function loadData(){
  currentType = document.getElementById('type').value;

  const res = await fetch(`api/masters_api.php?action=fetch&type=${currentType}`);
  const data = await res.json();

  renderTable(data);
}

// RENDER
function renderTable(data){
  const tbody = document.getElementById('table-body');
  tbody.innerHTML = '';

  data.forEach(item => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${item.name}</td>
      <td>
	   <button onclick="editItem(${item.id}, \`${item.name}\`)">Edit</button>
        <button onclick="deleteItem(${item.id})">Delete</button>
      </td>
    `;

    tbody.appendChild(tr);
  });
}

// ADD
async function addItem(){
  const name = document.getElementById('name').value;

  if(!name){
    alert("Enter value");
    return;
  }

  await fetch('api/masters_api.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({
      action: 'add',
      type: currentType,
      name: name
    })
  });

  document.getElementById('name').value = '';
  loadData();
}

// EDIT
async function editItem(id, oldName){
  const name = prompt("Edit value:", oldName);
  if(!name) return;

  await fetch('api/masters_api.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({
      action: 'update',
      type: currentType,
      id: id,
      name: name
    })
  });

  loadData();
}

// DELETE
async function deleteItem(id){
  if(!confirm("Delete this item?")) return;

  await fetch('api/masters_api.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({
      action: 'delete',
      type: currentType,
      id: id
    })
  });

  loadData();
}

// INIT
window.onload = loadData;
</script>

</body>
</html>
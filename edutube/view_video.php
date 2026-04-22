<!--view_video.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>EduTube — View</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="./css/style.css"> 
</head>
<body>

<nav>
  <div class="nav-logo">🎬 <span>Edu</span>Tube</div>
  <button onclick="window.location.href='manage_videos.php'" class="back-btn">← Back</button>
</nav>

<!-- ═══════════════ UPLOAD PAGE ═══════════════ -->
<div class="page active" id="page-upload">
<div class="upload-wrap">
  <div class="page-header">
    <h1>View Tutorial</h1>
    <div class="accent-line"></div>
    <p>View tutorial details</p>
  </div>

  <div class="form-card">
    <!-- Section 1: Video Details -->
    <div class="form-section-title">📹 Video Information</div>
    <div class="form-grid">
      <div class="form-group full">
        <label>Video Title *</label>
        <input type="text" id="f-title" placeholder="e.g. Introduction to Data Structures — Arrays & Linked Lists"/>
      </div>
      <div class="form-group full">
        <label>Short Description</label>
        <textarea id="f-desc" placeholder="Brief overview of what this video covers…" rows="2"></textarea>
      </div>
    </div>

    <!-- Section 2: Academic Classification -->
    <div class="form-section-title">🏫 Academic Classification</div>
    <div class="form-grid cols3">
      <div class="form-group">
        <label>Branch *</label>
        <select id="f-branch"></select>
      </div>
      <div class="form-group">
        <label>Semester *</label>
        <select id="f-sem"></select>
      </div>
	  <div class="form-group">
       <label>Curriculum *</label>
       <select id="f-curriculum"></select>
      </div>
      <div class="form-group">
        <label>Subject Name *</label>
        <input type="text" id="f-subject" placeholder="e.g. Data Structures & Algorithms"/>
      </div>
      <div class="form-group">
        <label>Lecturer / Author *</label>
        <select id="f-lecturer"></select>
      </div>
     <!-- <div class="form-group">
        <label>Duration (optional)</label>
        <input type="text" id="f-duration" placeholder="e.g. 45:30"/>
      </div> -->
    </div>

    <!-- Section 3: Keywords -->
    <div class="form-section-title">🏷️ Keywords & Tags</div>
    <div class="form-grid">
      <div class="form-group full">
        <label>Keywords (comma-separated)</label>
        <input type="text" id="f-keywords" placeholder="arrays, linked list, sorting, recursion, data structures"/>
        <span class="hint">These help students find this video via search</span>
      </div>
    </div>

    <!-- Section 4: YouTube Link -->
    <div class="form-section-title">🔗 YouTube Link & Preview</div>
    <div class="form-grid">
      <div class="form-group">
        <label>YouTube URL *</label>
        <input type="url" id="f-yturl" placeholder="https://www.youtube.com/watch?v=..." oninput="previewYT()"/>
      </div>
      <div class="form-group">
        <label>Preview</label>
        <div class="preview-box" id="yt-preview">
          <div class="preview-icon">▶</div>
		  <span>Paste a YouTube URL to preview</span>
        </div>
      </div>
    </div>
  </div>
</div>
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



<div class="toast" id="toast"></div>

<script>
let dropdownData = {};

const params = new URLSearchParams(window.location.search);
const videoId = params.get("id");

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
function initials(name){
  return name.split(' ').map(w=>w[0]).join('').toUpperCase();
}



//window.onload = loadVideos;
window.onload = () => {
  loadDropdowns().then(() => {
    loadVideo();
  });
};


async function loadDropdowns(){
  const res = await fetch('api/fetch_dropdowns.php');
  dropdownData = await res.json();

  fillSelect('f-branch', dropdownData.branches);
  fillSelect('f-sem', dropdownData.semesters);
  fillSelect('f-curriculum', dropdownData.curriculum);
  fillSelect('f-lecturer', dropdownData.lecturers);
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



/*function previewYT(){
  const url = document.getElementById('f-yturl').value;
  const id = ytId(url);
  const box = document.getElementById('yt-preview');

  if(id){
    box.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}" allowfullscreen></iframe>`;
  } else {
    box.innerHTML = `<div class="preview-icon">▶</div><span>Invalid YouTube URL</span>`;
  }
}
*/

function previewYT(){
  const url = document.getElementById('f-yturl').value;
  const id = ytId(url);
  const box = document.getElementById('yt-preview');

  if(!id){
    box.innerHTML = `<div class="preview-icon">▶</div><span>Invalid YouTube URL</span>`;
    return;
  }

  box.innerHTML = `
    <iframe 
      src="https://www.youtube.com/embed/${id}" 
      allowfullscreen
      onerror="showYTError()"
    ></iframe>
  `;

  // fallback timeout (if video doesn't load)
  setTimeout(() => {
    if (!box.querySelector('iframe').contentWindow) {
      showYTError();
    }
  }, 4000);
}

function showYTError(){
  const url = document.getElementById('f-yturl').value;

  const box = document.getElementById('yt-preview');
  box.innerHTML = `
    <div class="preview-icon">⚠</div>
    <span>Video failed to load</span>
    <a href="${url}" target="_blank" style="color:#ff6b4a;margin-top:6px;">
      Open on YouTube ↗
    </a>
  `;
}


function resetForm(){
  document.querySelectorAll('input, textarea').forEach(i => i.value='');
  document.querySelectorAll('select').forEach(s => s.selectedIndex=0);
  document.getElementById('yt-preview').innerHTML =
    `<div class="preview-icon">▶</div><span>Paste a YouTube URL to preview</span>`;
}

function showToast(msg, color='#2ecc71'){
  const t = document.getElementById('toast');
  t.innerText = msg;
  t.style.background = color;
  t.classList.add('show');
  setTimeout(()=> t.classList.remove('show'), 2500);
}

function fillSelect(id, data){
  const select = document.getElementById(id);

  if(!select) return; // ✅ prevents crash

  let label = "Select Option";
  if(id.includes("branch")) label = "Select Branch";
  if(id.includes("sem")) label = "Select Semester";
  if(id.includes("curriculum")) label = "Select Curriculum";
  if(id.includes("lecturer")) label = "Select Lecturer";

  select.innerHTML = `<option value="">${label}</option>`;

  data.forEach(item => {
    const opt = document.createElement("option");
    opt.value = item.name;
    opt.textContent = item.name;
    select.appendChild(opt);
  });
}


function disableForm(){
  document.querySelectorAll('input, textarea').forEach(el => el.readOnly = true);
  document.querySelectorAll('select').forEach(el => el.disabled = true);
}


async function loadVideo(){
  if(!videoId) return;

  const res = await fetch(`api/fetch_single_video.php?id=${videoId}`);
  const v = await res.json();

  document.getElementById('f-title').value = v.video_title || '';
  document.getElementById('f-desc').value = v.description || '';
  document.getElementById('f-branch').value = v.branch || '';
  document.getElementById('f-sem').value = v.semester || '';
  document.getElementById('f-curriculum').value = v.curriculum || '';
  document.getElementById('f-subject').value = v.subject_name || '';
  document.getElementById('f-lecturer').value = v.lecturer || '';
  document.getElementById('f-keywords').value = v.keywords || '';
  document.getElementById('f-yturl').value = v.youtube_url || '';

  previewYT();

  disableForm(); // 🔒 makes it readonly
}
</script>
</body>
</html>
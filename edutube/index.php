<!--index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>EduTube — Tutorial Manager</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
<style>
  :root {
    --bg: #0b0f1a;
    --surface: #131929;
    --surface2: #1a2235;
    --border: #1e2d47;
    --accent: #e8432d;
    --accent2: #ff6b4a;
    --gold: #f5a623;
    --text: #e8edf5;
    --muted: #6b7a99;
    --success: #2ecc71;
    --radius: 12px;
    --font-head: 'Syne', sans-serif;
    --font-body: 'DM Sans', sans-serif;
  }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; }

  /* NAV */
  nav {
    background: rgba(11,15,26,0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    position: sticky; top:0; z-index:100;
    display:flex; align-items:center; justify-content:space-between;
    padding: 0 32px; height: 64px;
  }
  .nav-logo { font-family:var(--font-head); font-weight:800; font-size:1.3rem; display:flex;align-items:center;gap:8px; }
  .nav-logo span { color:var(--accent); }
  .nav-tabs { display:flex; gap:4px; }
  .nav-tab {
    padding: 8px 20px; border-radius: 8px; cursor:pointer;
    font-family:var(--font-head); font-weight:600; font-size:0.85rem;
    letter-spacing:.5px; border:none; background:transparent;
    color:var(--muted); transition: all .2s;
  }
  .nav-tab:hover { color:var(--text); background:var(--surface2); }
  .nav-tab.active { background:var(--accent); color:#fff; }
  .nav-right { display:flex;align-items:center;gap:12px; }
  .badge { background:var(--accent); color:#fff; border-radius:20px; padding:2px 10px; font-size:.75rem; font-weight:600; }

  /* PAGES */
  .page { display:none; }
  .page.active { display:block; }

  /* ─────────────── UPLOAD PAGE ─────────────── */
  .upload-wrap {
    max-width: 900px; margin: 48px auto; padding: 0 24px 80px;
  }
  .page-header { margin-bottom:36px; }
  .page-header h1 { font-family:var(--font-head); font-size:2.2rem; font-weight:800; }
  .page-header p { color:var(--muted); margin-top:6px; font-size:.95rem; }
  .accent-line { width:48px;height:4px;background:var(--accent);border-radius:2px;margin:12px 0; }

  .form-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:16px;
    padding: 36px;
  }
  .form-section-title {
    font-family:var(--font-head); font-weight:700; font-size:.8rem;
    text-transform:uppercase; letter-spacing:2px; color:var(--accent);
    margin-bottom:20px; padding-bottom:10px;
    border-bottom:1px solid var(--border);
  }
  .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px; }
  .form-grid.cols3 { grid-template-columns:1fr 1fr 1fr; }
  .form-group { display:flex; flex-direction:column; gap:7px; }
  .form-group.full { grid-column: 1 / -1; }
  label { font-size:.8rem; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:.8px; }
  input, select, textarea {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text);
    font-family: var(--font-body);
    font-size: .95rem;
    padding: 11px 14px;
    outline:none;
    transition: border-color .2s, box-shadow .2s;
    width:100%;
  }
  input:focus, select:focus, textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(232,67,45,.12);
  }
  select option { background: var(--surface2); }
  textarea { resize:vertical; min-height:80px; }

  /* Preview area */
  .preview-box {
    background:var(--surface2); border:1px solid var(--border);
    border-radius:10px; overflow:hidden; aspect-ratio:16/9;
    display:flex; align-items:center; justify-content:center;
    flex-direction:column; gap:8px; color:var(--muted);
    font-size:.85rem; transition:all .3s;
  }
  .preview-box iframe { width:100%;height:100%;border:none; }
  .preview-icon { font-size:2.5rem; opacity:.3; }

  .hint { font-size:.75rem; color:var(--muted); margin-top:3px; }

  .btn-row { display:flex; gap:12px; justify-content:flex-end; margin-top:28px; }
  .btn {
    padding: 11px 28px; border-radius:9px; border:none; cursor:pointer;
    font-family:var(--font-head); font-weight:700; font-size:.88rem;
    letter-spacing:.5px; transition:all .2s;
  }
  .btn-primary { background:var(--accent); color:#fff; }
  .btn-primary:hover { background:var(--accent2); transform:translateY(-1px); box-shadow:0 4px 20px rgba(232,67,45,.3); }
  .btn-ghost { background:transparent; color:var(--muted); border:1px solid var(--border); }
  .btn-ghost:hover { color:var(--text); border-color:var(--muted); }

  .toast {
    position:fixed; bottom:30px; right:30px; z-index:999;
    background:var(--success); color:#fff; padding:14px 22px;
    border-radius:10px; font-weight:600; font-size:.9rem;
    transform:translateY(80px); opacity:0; transition:all .35s cubic-bezier(.34,1.56,.64,1);
    display:flex;align-items:center;gap:8px;
  }
  .toast.show { transform:translateY(0); opacity:1; }

  /* ─────────────── TUTORIALS PAGE ─────────────── */
  .tutorials-wrap { padding: 36px 32px 80px; max-width:1400px; margin:0 auto; }

  .filter-bar {
    background:var(--surface); border:1px solid var(--border);
    border-radius:14px; padding:20px 24px;
    display:flex; flex-wrap:wrap; gap:12px;
    align-items:center; margin-bottom:32px;
  }
  .search-box {
    flex:1; min-width:220px; position:relative;
  }
  .search-box input { padding-left:40px; }
  .search-icon { position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:1rem; pointer-events:none; }
  .filter-select {
    min-width:140px; flex:0 0 auto;
    background:var(--surface2); border:1px solid var(--border);
    border-radius:8px; color:var(--text); padding:10px 14px;
    font-family:var(--font-body); font-size:.88rem; outline:none; cursor:pointer;
  }
  .filter-select:focus { border-color:var(--accent); }
  .sort-group { display:flex;gap:6px; margin-left:auto; }
  .sort-btn {
    padding:8px 14px; border-radius:7px; border:1px solid var(--border);
    background:transparent; color:var(--muted); font-size:.8rem;
    cursor:pointer; font-family:var(--font-head); font-weight:600;
    transition:all .2s;
  }
  .sort-btn.active, .sort-btn:hover { background:var(--accent); color:#fff; border-color:var(--accent); }

  .results-meta { color:var(--muted); font-size:.85rem; margin-bottom:20px; }
  .results-meta strong { color:var(--text); }

  .grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
    gap:22px;
  }

  .card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:14px; overflow:hidden;
    transition: transform .25s, box-shadow .25s, border-color .25s;
    cursor:pointer; position:relative;
  }
  .card:hover { transform:translateY(-4px); box-shadow:0 16px 48px rgba(0,0,0,.4); border-color:#2a3f5f; }

  .card-thumb {
    position:relative; aspect-ratio:16/9; overflow:hidden;
    background:#0d1525;
  }
  .card-thumb img { width:100%;height:100%;object-fit:cover; transition:transform .4s; }
  .card:hover .card-thumb img { transform:scale(1.05); }
  .play-overlay {
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    background:rgba(0,0,0,.45); opacity:0; transition:opacity .25s;
  }
  .card:hover .play-overlay { opacity:1; }
  .play-btn {
    width:52px;height:52px;border-radius:50%;
    background:var(--accent); display:flex;align-items:center;justify-content:center;
    font-size:1.3rem;
  }
  .card-meta-top {
    position:absolute; top:10px; left:10px; right:10px;
    display:flex; justify-content:space-between; align-items:flex-start;
  }
  .chip {
    background:rgba(11,15,26,.85); backdrop-filter:blur(6px);
    border:1px solid var(--border); border-radius:6px;
    padding:3px 9px; font-size:.7rem; font-weight:600;
    font-family:var(--font-head); color:var(--gold);
  }
  .chip.sem { color:#a78bfa; }
  .more-btn {
    background:rgba(11,15,26,.85); backdrop-filter:blur(6px);
    border:1px solid var(--border); border-radius:6px;
    width:28px;height:28px;display:flex;align-items:center;justify-content:center;
    font-size:1.1rem; color:var(--muted); cursor:pointer;
    transition:color .2s;
    position:relative;
  }
  .more-btn:hover { color:var(--text); }
  .dropdown-menu {
    position:absolute;top:32px;right:0;
    background:var(--surface2); border:1px solid var(--border);
    border-radius:8px; padding:4px; min-width:130px;
    z-index:10; display:none; box-shadow:0 8px 30px rgba(0,0,0,.5);
  }
  .dropdown-menu.open { display:block; }
  .dropdown-item {
    padding:8px 12px; border-radius:5px; cursor:pointer;
    font-size:.82rem; display:flex;align-items:center;gap:8px;
    transition:background .15s; color:var(--text);
  }
  .dropdown-item:hover { background:var(--border); }
  .dropdown-item.danger { color:#ff6b6b; }

  .card-body { padding:16px; }
  .card-title { font-family:var(--font-head); font-weight:700; font-size:.97rem; line-height:1.4; margin-bottom:8px; }
  .card-subject { color:var(--accent2); font-size:.78rem; font-weight:500; margin-bottom:10px; }
  .card-tags { display:flex; flex-wrap:wrap; gap:5px; margin-bottom:12px; }
  .tag {
    background:var(--surface2); border:1px solid var(--border);
    border-radius:5px; padding:2px 8px; font-size:.7rem; color:var(--muted);
  }
  .card-footer {
    display:flex; align-items:center; justify-content:space-between;
    padding:10px 16px 14px;
  }
  .lecturer-info { display:flex;align-items:center;gap:8px; }
  .avatar {
    width:28px;height:28px;border-radius:50%;
    background:linear-gradient(135deg,var(--accent),var(--gold));
    display:flex;align-items:center;justify-content:center;
    font-size:.7rem; font-weight:700; color:#fff;
    flex-shrink:0;
  }
  .lecturer-name { font-size:.78rem; color:var(--muted); }
  .views { font-size:.75rem; color:var(--muted); display:flex;align-items:center;gap:4px; }

  .no-results {
    grid-column:1/-1; text-align:center; padding:80px 0;
    color:var(--muted);
  }
  .no-results .icon { font-size:3rem; margin-bottom:16px; opacity:.3; }
  .no-results h3 { font-family:var(--font-head); color:var(--text); margin-bottom:6px; }

  /* MODAL */
  .modal-overlay {
    position:fixed;inset:0;z-index:200;
    background:rgba(7,10,18,.92); backdrop-filter:blur(8px);
    display:flex;align-items:center;justify-content:center;
    opacity:0;pointer-events:none;transition:opacity .3s;
  }
  .modal-overlay.open { opacity:1;pointer-events:all; }
  .modal {
    background:var(--surface); border:1px solid var(--border);
    border-radius:18px; max-width:820px; width:calc(100% - 40px);
    max-height:90vh; overflow-y:auto;
    transform:scale(.95) translateY(20px); transition:transform .3s;
  }
  .modal-overlay.open .modal { transform:scale(1) translateY(0); }
  .modal-header {
    padding:24px 28px 0; display:flex;justify-content:space-between;align-items:flex-start;
  }
  .modal-title { font-family:var(--font-head); font-weight:800; font-size:1.2rem; }
  .modal-subtitle { color:var(--muted); font-size:.85rem; margin-top:4px; }
  .modal-close {
    background:var(--surface2); border:1px solid var(--border);
    border-radius:8px; width:34px;height:34px;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer; font-size:1.1rem; color:var(--muted);
    transition:all .2s; flex-shrink:0;
  }
  .modal-close:hover { color:var(--text); border-color:var(--muted); }
  .modal-video { margin:20px 28px 0; aspect-ratio:16/9; border-radius:10px; overflow:hidden; background:#000; }
  .modal-video iframe { width:100%;height:100%;border:none; }
  .modal-info { padding:20px 28px 28px; display:grid;grid-template-columns:1fr 1fr;gap:14px; }
  .info-item label { font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);font-weight:600; }
  .info-item p { font-size:.9rem; margin-top:3px; }

  /* EDIT MODAL */
  .edit-modal { max-width:700px; }
  .edit-modal .modal-body { padding: 24px 28px 28px; }

  /* DB SCHEMA PAGE */
  .schema-wrap { max-width:900px; margin:48px auto; padding:0 24px 80px; }
  .schema-table { width:100%; border-collapse:collapse; margin-bottom:32px; }
  .schema-table th {
    background:var(--surface2); padding:10px 16px; text-align:left;
    font-family:var(--font-head); font-size:.78rem; letter-spacing:.8px;
    text-transform:uppercase; color:var(--accent); border-bottom:2px solid var(--border);
  }
  .schema-table td { padding:10px 16px; border-bottom:1px solid var(--border); font-size:.87rem; }
  .schema-table tr:hover td { background:var(--surface2); }
  code { background:var(--surface2); border:1px solid var(--border); border-radius:4px; padding:2px 7px; font-size:.82rem; color:#7dd3fc; font-family:monospace; }
  .extra-tag { background:rgba(245,166,35,.12); border:1px solid rgba(245,166,35,.3); border-radius:4px; padding:1px 7px; font-size:.7rem; color:var(--gold); margin-left:6px; }

  @media(max-width:680px){
    .form-grid,.form-grid.cols3 { grid-template-columns:1fr; }
    .filter-bar { gap:8px; }
    .tutorials-wrap { padding:20px 16px 60px; }
    .modal-info { grid-template-columns:1fr; }
  }
</style>
</head>
<body>

<nav>
  <div class="nav-logo">🎬 <span>Edu</span>Tube</div>
  <div class="nav-tabs">
    <button class="nav-tab active" onclick="showPage('upload')">📤 Upload</button>
    <button class="nav-tab" onclick="showPage('tutorials')">🎓 Tutorials</button>
    <button class="nav-tab" onclick="showPage('schema')">🗄️ DB Schema</button>
  </div>
  <div class="nav-right">
    <span class="badge" id="total-count">0 videos</span>
  </div>
</nav>

<!-- ═══════════════ UPLOAD PAGE ═══════════════ -->
<div class="page active" id="page-upload">
<div class="upload-wrap">
  <div class="page-header">
    <h1>Upload Tutorial</h1>
    <div class="accent-line"></div>
    <p>Add a new YouTube tutorial to the knowledge base</p>
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
        <select id="f-branch">
          <option value="">Select Branch</option>
          <option>Computer Science (CS)</option>
          <option>Information Technology (IT)</option>
          <option>Electronics & Communication (EC)</option>
          <option>Electrical Engineering (EE)</option>
          <option>Mechanical Engineering (ME)</option>
          <option>Civil Engineering (CE)</option>
          <option>Chemical Engineering (CH)</option>
          <option>MBA</option>
          <option>MCA</option>
        </select>
      </div>
      <div class="form-group">
        <label>Semester *</label>
        <select id="f-sem">
          <option value="">Semester</option>
          <option>1st Semester</option><option>2nd Semester</option>
          <option>3rd Semester</option><option>4th Semester</option>
          <option>5th Semester</option><option>6th Semester</option>
          <option>7th Semester</option><option>8th Semester</option>
        </select>
      </div>
      <div class="form-group">
        <label>Curriculum *</label>
        <select id="f-curriculum">
          <option value="">Select Curriculum</option>
          <option>NEP 2020</option>
          <option>CBCS (Choice Based)</option>
          <option>Traditional / Old Scheme</option>
          <option>Autonomous</option>
          <option>AICTE 2021</option>
        </select>
      </div>
      <div class="form-group">
        <label>Subject Name *</label>
        <input type="text" id="f-subject" placeholder="e.g. Data Structures & Algorithms"/>
      </div>
      <div class="form-group">
        <label>Lecturer / Author *</label>
        <select id="f-lecturer">
          <option value="">Select Lecturer</option>
          <option>Dr. Priya Sharma</option>
          <option>Prof. Rajan Mehta</option>
          <option>Dr. Anita Desai</option>
          <option>Prof. Suresh Kumar</option>
          <option>Dr. Kavita Nair</option>
          <option>External / Guest Lecturer</option>
        </select>
      </div>
      <div class="form-group">
        <label>Duration (optional)</label>
        <input type="text" id="f-duration" placeholder="e.g. 45:30"/>
      </div>
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
        <span class="hint">Paste the full YouTube video URL</span>
      </div>
      <div class="form-group">
        <label>Preview</label>
        <div class="preview-box" id="yt-preview">
          <div class="preview-icon">▶</div>
          <span>Paste a YouTube URL to preview</span>
        </div>
      </div>
    </div>

    <div class="btn-row">
      <button class="btn btn-ghost" onclick="resetForm()">Clear Form</button>
      <button class="btn btn-primary" onclick="submitVideo()">📤 Add Tutorial</button>
    </div>
  </div>
</div>
</div>

<!-- ═══════════════ TUTORIALS PAGE ═══════════════ -->
<div class="page" id="page-tutorials">
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
      <option>Computer Science (CS)</option>
      <option>Information Technology (IT)</option>
      <option>Electronics & Communication (EC)</option>
      <option>Electrical Engineering (EE)</option>
      <option>Mechanical Engineering (ME)</option>
      <option>Civil Engineering (CE)</option>
      <option>MBA</option><option>MCA</option>
    </select>
    <select class="filter-select" id="s-sem" onchange="filterCards()">
      <option value="">All Semesters</option>
      <option>1st Semester</option><option>2nd Semester</option>
      <option>3rd Semester</option><option>4th Semester</option>
      <option>5th Semester</option><option>6th Semester</option>
      <option>7th Semester</option><option>8th Semester</option>
    </select>
    <select class="filter-select" id="s-curriculum" onchange="filterCards()">
      <option value="">All Curricula</option>
      <option>NEP 2020</option><option>CBCS (Choice Based)</option>
      <option>Traditional / Old Scheme</option><option>Autonomous</option>
      <option>AICTE 2021</option>
    </select>
    <select class="filter-select" id="s-lecturer" onchange="filterCards()">
      <option value="">All Lecturers</option>
      <option>Dr. Priya Sharma</option><option>Prof. Rajan Mehta</option>
      <option>Dr. Anita Desai</option><option>Prof. Suresh Kumar</option>
      <option>Dr. Kavita Nair</option>
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
</div>

<!-- ═══════════════ DB SCHEMA PAGE ═══════════════ -->
<div class="page" id="page-schema">
<div class="schema-wrap">
  <div class="page-header">
    <h1>Database Schema</h1>
    <div class="accent-line"></div>
    <p>Reference for backend implementation</p>
  </div>

  <div class="form-card" style="margin-bottom:28px;">
    <div class="form-section-title">📋 Table: videos</div>
    <table class="schema-table">
      <tr><th>Column</th><th>Type</th><th>Notes</th></tr>
      <tr><td><code>id</code></td><td>INT PK AUTO</td><td>Primary key</td></tr>
      <tr><td><code>video_title</code></td><td>VARCHAR(255)</td><td>Required</td></tr>
      <tr><td><code>description</code></td><td>TEXT</td><td>Short overview <span class="extra-tag">✨ extra</span></td></tr>
      <tr><td><code>branch</code></td><td>VARCHAR(100)</td><td>CS / IT / ME …</td></tr>
      <tr><td><code>semester</code></td><td>TINYINT</td><td>1–8</td></tr>
      <tr><td><code>curriculum</code></td><td>VARCHAR(100)</td><td>NEP 2020, CBCS …</td></tr>
      <tr><td><code>subject_name</code></td><td>VARCHAR(150)</td><td>Required</td></tr>
      <tr><td><code>keywords</code></td><td>TEXT</td><td>Comma-separated tags</td></tr>
      <tr><td><code>author_id</code></td><td>INT FK</td><td>→ lecturers.id</td></tr>
      <tr><td><code>youtube_url</code></td><td>VARCHAR(500)</td><td>Full watch URL</td></tr>
      <tr><td><code>youtube_embed</code></td><td>VARCHAR(500)</td><td>Auto-derived embed URL</td></tr>
      <tr><td><code>thumbnail_url</code></td><td>VARCHAR(500)</td><td>Auto from YouTube ID <span class="extra-tag">✨ extra</span></td></tr>
      <tr><td><code>duration</code></td><td>VARCHAR(20)</td><td>e.g. "45:30" <span class="extra-tag">✨ extra</span></td></tr>
      <tr><td><code>views_count</code></td><td>INT DEFAULT 0</td><td>Increment on open <span class="extra-tag">✨ extra</span></td></tr>
      <tr><td><code>is_active</code></td><td>TINYINT(1) DEFAULT 1</td><td>Soft delete flag <span class="extra-tag">✨ extra</span></td></tr>
      <tr><td><code>created_at</code></td><td>DATETIME</td><td>Auto timestamp</td></tr>
      <tr><td><code>updated_at</code></td><td>DATETIME</td><td>Auto timestamp</td></tr>
    </table>

    <div class="form-section-title">👨‍🏫 Table: lecturers</div>
    <table class="schema-table">
      <tr><th>Column</th><th>Type</th><th>Notes</th></tr>
      <tr><td><code>id</code></td><td>INT PK AUTO</td><td>Primary key</td></tr>
      <tr><td><code>name</code></td><td>VARCHAR(150)</td><td>Full name</td></tr>
      <tr><td><code>department</code></td><td>VARCHAR(100)</td><td>Branch / dept</td></tr>
      <tr><td><code>email</code></td><td>VARCHAR(150)</td><td>Optional</td></tr>
      <tr><td><code>profile_img</code></td><td>VARCHAR(500)</td><td>Avatar URL <span class="extra-tag">✨ extra</span></td></tr>
    </table>

    <div class="form-section-title">🔄 Update / Delete Strategy</div>
    <div style="color:var(--muted);font-size:.9rem;line-height:1.9;">
      <p>Each card has a <strong style="color:var(--text)">⋮ menu</strong> — clicking it shows <strong style="color:var(--text)">Edit</strong> and <strong style="color:var(--text)">Delete</strong> options.</p>
      <br>
      <p>✏️ <strong style="color:var(--text)">Edit</strong> → Opens the upload form pre-filled with existing data. On save: <code>PUT /api/videos/:id</code></p>
      <p>🗑️ <strong style="color:var(--text)">Delete</strong> → Two options:</p>
      <p style="padding-left:20px;">• <em>Soft delete</em>: set <code>is_active = 0</code> — video hidden but recoverable</p>
      <p style="padding-left:20px;">• <em>Hard delete</em>: <code>DELETE FROM videos WHERE id = ?</code> — permanent</p>
      <br>
      <p>🔁 An <strong style="color:var(--text)">Admin Panel</strong> page can show soft-deleted videos with a Restore option.</p>
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

<!-- EDIT MODAL -->
<div class="modal-overlay" id="edit-modal" onclick="closeEditModal(event)">
  <div class="modal edit-modal" onclick="event.stopPropagation()">
    <div class="modal-header">
      <div><div class="modal-title">Edit Tutorial</div></div>
      <div class="modal-close" onclick="closeEditModal()">✕</div>
    </div>
    <div class="modal-body edit-modal">
      <div style="padding:24px 0 0;">
        <div class="form-grid">
          <div class="form-group full"><label>Title</label><input id="e-title"/></div>
          <div class="form-group"><label>Branch</label><select id="e-branch">
            <option>Computer Science (CS)</option><option>Information Technology (IT)</option>
            <option>Electronics & Communication (EC)</option><option>Mechanical Engineering (ME)</option>
            <option>Civil Engineering (CE)</option><option>MBA</option><option>MCA</option>
          </select></div>
          <div class="form-group"><label>Semester</label><select id="e-sem">
            <option>1st Semester</option><option>2nd Semester</option><option>3rd Semester</option>
            <option>4th Semester</option><option>5th Semester</option><option>6th Semester</option>
            <option>7th Semester</option><option>8th Semester</option>
          </select></div>
          <div class="form-group"><label>Subject</label><input id="e-subject"/></div>
          <div class="form-group"><label>Lecturer</label><select id="e-lecturer">
            <option>Dr. Priya Sharma</option><option>Prof. Rajan Mehta</option>
            <option>Dr. Anita Desai</option><option>Prof. Suresh Kumar</option><option>Dr. Kavita Nair</option>
          </select></div>
          <div class="form-group full"><label>Keywords</label><input id="e-keywords"/></div>
        </div>
        <div class="btn-row">
          <button class="btn btn-ghost" onclick="closeEditModal()">Cancel</button>
          <button class="btn btn-primary" onclick="saveEdit(event)">💾 Save Changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
let videos = [];
let editTarget = null;
let currentSort = 'newest';
let dropdownData = {};


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

// ─── LOAD ───
async function loadVideos(){
  const res = await fetch('fetch_videos.php');
  videos = await res.json();
  console.log(videos);
  //renderCards(videos);
  filterCards();
  updateCount();
  console.log("Curriculum values:", videos.map(v => v.curriculum));
}
//window.onload = loadVideos;
window.onload = () => {
  loadVideos();
  loadDropdowns(); // 🔥 THIS LINE
};


async function loadDropdowns(){
  const res = await fetch('fetch_dropdowns.php');
  dropdownData = await res.json();

  fillSelect('f-branch', dropdownData.branches);
  fillSelect('f-sem', dropdownData.semesters);
  fillSelect('f-curriculum', dropdownData.curriculum);
  fillSelect('f-lecturer', dropdownData.lecturers);

  // also for modal
  fillSelect('e-branch', dropdownData.branches);
  fillSelect('e-sem', dropdownData.semesters);
  fillSelect('e-lecturer', dropdownData.lecturers);
}

// ─── SUBMIT ───
async function submitVideo(){
  const data = {
    title: f('f-title'),
    desc: f('f-desc'),
    branch: f('f-branch'),
    sem: f('f-sem'),
    curriculum: f('f-curriculum'),
    subject: f('f-subject'),
    lecturer: f('f-lecturer'),
    keywords: f('f-keywords'),
    ytUrl: f('f-yturl'),
	
  };

  if(!data.title || !data.ytUrl){
    showToast('⚠️ Title & URL required', '#e8432d');
    return;
  }

console.log("TITLE:", f('f-title'));
console.log("URL:", f('f-yturl'));

  await fetch('add_video.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });

  showToast('✅ Saved to database!');
  resetForm();
  loadVideos();
}

function f(id){
  return document.getElementById(id).value;
}

// ─── DELETE ───
async function deleteVideo(e, id){
  e.stopPropagation();
  if(!confirm("Delete this video?")) return;

  await fetch(`delete_video.php?id=${id}`);
  loadVideos();
}

// ─── EDIT ───
/*function openEditModal(e, id){
  e.stopPropagation();

  editTarget = id;
  const v = videos.find(x => x.id == id);

  document.getElementById('e-title').value = v.video_title;
  document.getElementById('e-subject').value = v.subject_name;
  document.getElementById('e-branch').value = v.branch;
  document.getElementById('e-sem').value = v.semester;
  document.getElementById('e-lecturer').value = v.lecturer || '';
  document.getElementById('e-keywords').value = Array.isArray(v.keywords) ? v.keywords.join(',') : v.keywords;

  document.getElementById('edit-modal').classList.add('open');
}

function closeEditModal(e){
  if(e) e.stopPropagation();
  document.getElementById('edit-modal').classList.remove('open');
}
*/

function openEditModal(e, id){
  e.stopPropagation();

  if(!dropdownData.branches){
    alert("Dropdown not loaded yet bro 😅");
    return;
  }

  editTarget = id;
  const v = videos.find(x => x.id == id);

  document.getElementById('e-title').value = v.video_title;
  document.getElementById('e-subject').value = v.subject_name;

  fillSelect('e-branch', dropdownData.branches, v.branch);
  fillSelect('e-sem', dropdownData.semesters, v.semester);
  fillSelect('e-lecturer', dropdownData.lecturers, v.lecturer);

  document.getElementById('e-keywords').value = v.keywords;

  document.getElementById('edit-modal').classList.add('open');
} 

function closeEditModal(e){
  if(e) e.stopPropagation();
  document.getElementById('edit-modal').classList.remove('open');
}


function saveEdit(e){
  if(e) e.stopPropagation();

  const data = {
    id: editTarget,
    title: document.getElementById('e-title').value,
    subject: document.getElementById('e-subject').value,
    branch: document.getElementById('e-branch').value,
    sem: document.getElementById('e-sem').value,
    lecturer: document.getElementById('e-lecturer').value,
    keywords: document.getElementById('e-keywords').value
  };

  fetch('update_video.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });

  closeEditModal();
  loadVideos();
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

// ─── VIDEO MODAL ───
/*function openVideoModal(v){
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
  `;

  // fetch and update views
  fetch(`update_views.php?id=${v.id}`)
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            v.views_count = data.views; // update local object
            // update modal view count
            const viewsDiv = document.createElement('div');
            viewsDiv.className = 'info-item';
            viewsDiv.innerHTML = `<label>Views</label><p>${v.views_count}</p>`;
            document.getElementById('modal-info').appendChild(viewsDiv);

            // also update the card span if you have one
            const span = document.getElementById(`views-${v.id}`);
            if(span) span.textContent = v.views_count;
        }
    });
}
*/


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
  fetch(`update_views.php?id=${v.id}`)
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

function updateCount(){
  document.getElementById('total-count').innerText = videos.length + ' videos';
}

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
      (!sem || v.semester === sem) &&
      (!cu || v.curriculum === cu) &&
      (!lecturer || v.lecturer === lecturer)
    );

  });

  sortList(filtered);
  renderCards(filtered);
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
    const tags = Array.isArray(v.keywords) ? v.keywords : [];

    // Branch abbreviation
 // Get branch abbreviation from name
let branchShort = '';
const match = v.branch.match(/\(([^)]+)\)/); // matches text inside ()
if(match){
  branchShort = match[1]; // the part inside brackets
} else {
  // fallback: take initials
  branchShort = v.branch
    .split(' ')
    .map(w => w[0])
    .join('')
    .toUpperCase();
}
    // Semester number only
    let semShort = v.semester ? v.semester.replace(/\D/g, '') : '';

    const card = document.createElement('div');
    card.className = 'card';
    card.onclick = () => openVideoModal(v);

    card.innerHTML = `
      <div class="card-thumb">
        <img src="${thumbUrl(v.youtube_url)}"/>
        <div class="play-overlay">
          <div class="play-btn">▶</div>
        </div>

        <div class="card-meta-top">
          <span class="chip branch">${branchShort}</span>
          <span class="chip sem">Sem ${semShort}</span>
        </div>

        <div class="more-btn" onclick="toggleMenu(event,this)">⋮
          <div class="dropdown-menu">
            <div class="dropdown-item" onclick="openEditModal(event, ${v.id})">✏️ Edit</div>
            <div class="dropdown-item danger" onclick="deleteVideo(event, ${v.id})">🗑️ Delete</div>
          </div>
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
          <div class="avatar">${initials(v.lecturer || 'L')}</div>
          <div class="lecturer-name">${v.lecturer || ''}</div>
        </div>
        <div class="views" id="views-${v.id}">👁 ${v.views_count || 0}</div>
      </div>
    `;

    grid.appendChild(card);
  });
}



function fillSelect(id, items, selectedValue = ''){
  const select = document.getElementById(id);

  select.innerHTML = '<option value="">Select</option>';

  items.forEach(item => {
    const selected = item.name === selectedValue ? 'selected' : '';
    select.innerHTML += `<option value="${item.name}" ${selected}>${item.name}</option>`;
  });
}

</script>
</body>
</html>
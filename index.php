<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Records System</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap');

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:      #0d0f14;
    --surface: #14171f;
    --card:    #1a1d27;
    --border:  #252836;
    --accent:  #5b6af0;
    --accent2: #f05b8a;
    --green:   #2dd4a0;
    --yellow:  #f0c05b;
    --text:    #e8eaf0;
    --muted:   #6b7080;
    --danger:  #f05b5b;
    --radius:  10px;
    --mono:    'Space Mono', monospace;
    --sans:    'Syne', sans-serif;
  }

  body { background: var(--bg); color: var(--text); font-family: var(--sans); min-height: 100vh; }

  /* HEADER */
  header {
    background: var(--surface); border-bottom: 1px solid var(--border);
    padding: 18px 32px; display: flex; align-items: center;
    justify-content: space-between; position: sticky; top: 0; z-index: 100;
  }
  .logo { display: flex; align-items: center; gap: 12px; }
  .logo-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px;
  }
  .logo h1 { font-size: 1.1rem; font-weight: 800; letter-spacing: -0.02em; }
  .logo span { font-size: 0.72rem; color: var(--muted); font-family: var(--mono); display: block; margin-top: 1px; }
  .badge {
    font-family: var(--mono); font-size: 0.68rem;
    background: rgba(91,106,240,0.15); color: var(--accent);
    border: 1px solid rgba(91,106,240,0.3); padding: 4px 10px; border-radius: 20px;
  }

  /* LAYOUT */
  .container { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }

  /* STATS */
  .stats { display: flex; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
  .stat-card {
    flex: 1; min-width: 150px; background: var(--card);
    border: 1px solid var(--border); border-radius: var(--radius);
    padding: 16px 20px; display: flex; align-items: center; gap: 14px; transition: border-color 0.2s;
  }
  .stat-card:hover { border-color: var(--accent); }
  .stat-icon { font-size: 22px; }
  .stat-num  { font-size: 1.6rem; font-weight: 800; line-height: 1; }
  .stat-label{ font-size: 0.72rem; color: var(--muted); font-family: var(--mono); margin-top: 3px; }

  /* TOOLBAR */
  .toolbar { display: flex; gap: 12px; align-items: center; margin-bottom: 20px; flex-wrap: wrap; }
  .search-wrap { position: relative; flex: 1; min-width: 200px; }
  .search-wrap input {
    width: 100%; background: var(--card); border: 1px solid var(--border);
    color: var(--text); font-family: var(--mono); font-size: 0.82rem;
    padding: 10px 14px 10px 38px; border-radius: var(--radius); outline: none; transition: border-color 0.2s;
  }
  .search-wrap input:focus { border-color: var(--accent); }
  .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; }

  .btn {
    font-family: var(--sans); font-weight: 700; font-size: 0.82rem;
    padding: 10px 18px; border-radius: var(--radius); border: none; cursor: pointer;
    transition: all 0.15s; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
  }
  .btn-primary   { background: var(--accent); color: #fff; }
  .btn-primary:hover  { background: #4a59df; transform: translateY(-1px); }
  .btn-danger    { background: transparent; color: var(--danger); border: 1px solid var(--danger); }
  .btn-danger:hover   { background: rgba(240,91,91,0.1); }
  .btn-edit      { background: transparent; color: var(--yellow); border: 1px solid var(--yellow); }
  .btn-edit:hover     { background: rgba(240,192,91,0.1); }
  .btn-secondary { background: var(--card); color: var(--text); border: 1px solid var(--border); }
  .btn-secondary:hover{ border-color: var(--accent); color: var(--accent); }
  .btn-sm { padding: 6px 12px; font-size: 0.75rem; }

  /* TABLE */
  .table-wrap { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: var(--surface); border-bottom: 1px solid var(--border); }
  th {
    padding: 13px 16px; text-align: left; font-family: var(--mono);
    font-size: 0.7rem; color: var(--muted); letter-spacing: 0.06em;
    text-transform: uppercase; cursor: pointer; user-select: none; white-space: nowrap;
  }
  th:hover { color: var(--accent); }
  th .sort-arrow { margin-left: 4px; opacity: 0.4; }
  th.active .sort-arrow { opacity: 1; color: var(--accent); }
  tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(91,106,240,0.05); }
  td { padding: 13px 16px; font-size: 0.84rem; vertical-align: middle; }

  .sid { font-family: var(--mono); font-size: 0.75rem; color: var(--accent); letter-spacing: 0.03em; }
  .name-cell  { font-weight: 700; }
  .email-cell { color: var(--muted); font-size: 0.78rem; font-family: var(--mono); }
  .course-pill {
    display: inline-block; background: rgba(91,106,240,0.1); color: var(--accent);
    border: 1px solid rgba(91,106,240,0.25); padding: 3px 9px; border-radius: 20px;
    font-size: 0.72rem; font-family: var(--mono); white-space: nowrap;
  }
  .year-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--surface); border: 1px solid var(--border);
    font-size: 0.78rem; font-weight: 700;
  }
  .gpa-cell { font-family: var(--mono); font-weight: 700; }
  .gpa-high { color: var(--green); }
  .gpa-mid  { color: var(--yellow); }
  .gpa-low  { color: var(--danger); }
  .actions  { display: flex; gap: 8px; }

  /* EMPTY STATE */
  .empty-state { padding: 60px 20px; text-align: center; }
  .empty-state .icon { font-size: 40px; margin-bottom: 12px; opacity: 0.4; }
  .empty-state p { color: var(--muted); font-size: 0.9rem; }

  /* MODAL */
  .overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px); z-index: 200;
    display: none; align-items: center; justify-content: center; padding: 20px;
  }
  .overlay.open { display: flex; animation: fadeIn 0.15s ease; }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  .modal {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; width: 100%; max-width: 520px;
    animation: slideUp 0.2s ease; max-height: 90vh; overflow-y: auto;
  }
  @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: none; opacity: 1; } }
  .modal-header {
    padding: 20px 24px 16px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .modal-title    { font-size: 1rem; font-weight: 800; }
  .modal-subtitle { font-size: 0.72rem; color: var(--muted); font-family: var(--mono); margin-top: 2px; }
  .close-btn { background: none; border: none; color: var(--muted); cursor: pointer; font-size: 18px; padding: 4px; border-radius: 6px; transition: color 0.15s; }
  .close-btn:hover { color: var(--text); }
  .modal-body { padding: 20px 24px; }
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-group { display: flex; flex-direction: column; gap: 6px; }
  .form-group.full { grid-column: 1 / -1; }
  label { font-size: 0.72rem; color: var(--muted); font-family: var(--mono); text-transform: uppercase; letter-spacing: 0.05em; }
  input, select {
    background: var(--surface); border: 1px solid var(--border);
    color: var(--text); font-family: var(--mono); font-size: 0.85rem;
    padding: 10px 12px; border-radius: 8px; outline: none; transition: border-color 0.2s; width: 100%;
  }
  input:focus, select:focus { border-color: var(--accent); }
  select option { background: var(--surface); }
  .input-error { border-color: var(--danger) !important; }
  .modal-footer {
    padding: 16px 24px 20px; border-top: 1px solid var(--border);
    display: flex; justify-content: flex-end; gap: 10px;
  }

  /* TOAST */
  #toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 999;
    font-family: var(--mono); font-size: 0.8rem; padding: 12px 20px; border-radius: 10px;
    display: flex; align-items: center; gap: 10px;
    transform: translateY(80px); opacity: 0;
    transition: all 0.3s cubic-bezier(.34,1.56,.64,1); max-width: 340px;
  }
  #toast.show { transform: none; opacity: 1; }
  #toast.success { background: rgba(45,212,160,0.15); border: 1px solid var(--green); color: var(--green); }
  #toast.error   { background: rgba(240,91,91,0.15);  border: 1px solid var(--danger); color: var(--danger); }

  /* DELETE CONFIRM */
  .confirm-modal { max-width: 380px; }
  .confirm-body  { padding: 24px; text-align: center; }
  .confirm-icon  { font-size: 36px; margin-bottom: 12px; }
  .confirm-body h3 { font-size: 1rem; margin-bottom: 8px; }
  .confirm-body p  { color: var(--muted); font-size: 0.85rem; line-height: 1.5; }

  @media (max-width: 700px) {
    .form-grid { grid-template-columns: 1fr; }
    .stats     { gap: 10px; }
    th, td     { padding: 10px 12px; }
    .course-pill { display: none; }
  }
</style>
</head>
<body>

<header>
  <div class="logo">
    <div class="logo-icon">🎓</div>
    <div>
      <h1>StudentBase</h1>
      <span>Records Management System</span>
    </div>
  </div>
  <span class="badge">● PHP + MySQL</span>
</header>

<div class="container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-card">
      <span class="stat-icon">👥</span>
      <div><div class="stat-num" id="stat-total">—</div><div class="stat-label">Total Students</div></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon">📚</span>
      <div><div class="stat-num" id="stat-courses">—</div><div class="stat-label">Courses</div></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon">⭐</span>
      <div><div class="stat-num" id="stat-avg-gpa">—</div><div class="stat-label">Avg GPA</div></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon">🏆</span>
      <div><div class="stat-num" id="stat-honors">—</div><div class="stat-label">Latin Honors</div></div>
    </div>
  </div>

  <!-- Toolbar -->
  <div class="toolbar">
    <div class="search-wrap">
      <span class="search-icon">🔍</span>
      <input type="text" id="searchInput" placeholder="Search by name, ID, course…" oninput="loadStudents()">
    </div>
    <button class="btn btn-primary" onclick="openAddModal()">+ Add Student</button>
  </div>

  <!-- Table -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th onclick="sortBy('student_id')" id="th-student_id">Student ID <span class="sort-arrow">↕</span></th>
          <th onclick="sortBy('last_name')"  id="th-last_name">Name <span class="sort-arrow">↕</span></th>
          <th>Email</th>
          <th onclick="sortBy('course')"     id="th-course">Course <span class="sort-arrow">↕</span></th>
          <th onclick="sortBy('year_level')" id="th-year_level">Year <span class="sort-arrow">↕</span></th>
          <th onclick="sortBy('gpa')"        id="th-gpa">GPA <span class="sort-arrow">↕</span></th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="studentTable">
        <tr><td colspan="7"><div class="empty-state"><div class="icon">⏳</div><p>Loading records…</p></div></td></tr>
      </tbody>
    </table>
  </div>

</div>

<!-- ADD / EDIT MODAL -->
<div class="overlay" id="formOverlay">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-title" id="modalTitle">Add Student</div>
        <div class="modal-subtitle" id="modalSubtitle">Fill in the student's details below</div>
      </div>
      <button class="close-btn" onclick="closeModal()">✕</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editId">
      <div class="form-grid">
        <div class="form-group">
          <label>Student ID *</label>
          <input type="text" id="f_student_id" placeholder="e.g. 2024-0001">
        </div>
        <div class="form-group">
          <label>GPA (1.0 – 5.0)</label>
          <input type="number" id="f_gpa" placeholder="e.g. 1.75" step="0.01" min="1" max="5">
        </div>
        <div class="form-group">
          <label>First Name *</label>
          <input type="text" id="f_first_name" placeholder="Maria">
        </div>
        <div class="form-group">
          <label>Last Name *</label>
          <input type="text" id="f_last_name" placeholder="Santos">
        </div>
        <div class="form-group full">
          <label>Email Address *</label>
          <input type="email" id="f_email" placeholder="student@school.edu">
        </div>
        <div class="form-group full">
          <label>Course *</label>
          <input type="text" id="f_course" placeholder="BS Computer Science">
        </div>
        <div class="form-group">
          <label>Year Level *</label>
          <select id="f_year_level">
            <option value="">— Select —</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
            <option value="5">5th Year</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
      <button class="btn btn-primary"   onclick="saveStudent()">💾 Save Record</button>
    </div>
  </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="overlay" id="deleteOverlay">
  <div class="modal confirm-modal">
    <div class="modal-header">
      <div class="modal-title">Confirm Deletion</div>
      <button class="close-btn" onclick="closeDeleteModal()">✕</button>
    </div>
    <div class="confirm-body">
      <div class="confirm-icon">🗑️</div>
      <h3>Delete Student Record?</h3>
      <p id="deleteMsg">This will permanently remove the student from the system.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
      <button class="btn btn-danger"    onclick="confirmDelete()">Delete Permanently</button>
    </div>
  </div>
</div>

<div id="toast"></div>

<script>
  let sortCol = 'id', sortDir = 'ASC', deleteId = null;

  // ── LOAD STUDENTS ──────────────────────────────
  async function loadStudents() {
    const search = document.getElementById('searchInput').value;
    const res    = await fetch(`api.php?action=read&search=${encodeURIComponent(search)}&sort=${sortCol}&dir=${sortDir}`);
    const json   = await res.json();
    if (!json.success) { showToast('Failed to load students', 'error'); return; }
    updateStats(json.data);
    renderTable(json.data);
  }

  function updateStats(data) {
    document.getElementById('stat-total').textContent   = data.length;
    document.getElementById('stat-courses').textContent = new Set(data.map(s => s.course)).size;
    const avg = data.length
      ? (data.reduce((s, r) => s + parseFloat(r.gpa || 0), 0) / data.length).toFixed(2)
      : '—';
    document.getElementById('stat-avg-gpa').textContent = avg;
    document.getElementById('stat-honors').textContent  = data.filter(s => parseFloat(s.gpa) <= 1.75).length;
  }

  function gpaClass(gpa) {
    gpa = parseFloat(gpa);
    if (gpa <= 1.75) return 'gpa-high';
    if (gpa <= 2.50) return 'gpa-mid';
    return 'gpa-low';
  }

  function renderTable(students) {
    const tbody = document.getElementById('studentTable');
    if (!students.length) {
      tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><div class="icon">🔍</div><p>No students found.</p></div></td></tr>`;
      return;
    }
    tbody.innerHTML = students.map(s => `
      <tr>
        <td><span class="sid">${esc(s.student_id)}</span></td>
        <td><div class="name-cell">${esc(s.last_name)}, ${esc(s.first_name)}</div></td>
        <td><span class="email-cell">${esc(s.email)}</span></td>
        <td><span class="course-pill">${esc(s.course)}</span></td>
        <td><span class="year-badge">${s.year_level}</span></td>
        <td><span class="gpa-cell ${gpaClass(s.gpa)}">${parseFloat(s.gpa).toFixed(2)}</span></td>
        <td>
          <div class="actions">
            <button class="btn btn-edit btn-sm"   onclick="openEditModal(${s.id})">✏️ Edit</button>
            <button class="btn btn-danger btn-sm" onclick="openDeleteModal(${s.id}, '${esc(s.first_name)} ${esc(s.last_name)}')">🗑️</button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  // ── SORT ───────────────────────────────────────
  function sortBy(col) {
    sortDir = (sortCol === col && sortDir === 'ASC') ? 'DESC' : 'ASC';
    sortCol = col;
    document.querySelectorAll('th').forEach(th => th.classList.remove('active'));
    const th = document.getElementById('th-' + col);
    if (th) {
      th.classList.add('active');
      th.querySelector('.sort-arrow').textContent = sortDir === 'ASC' ? '↑' : '↓';
    }
    loadStudents();
  }

  // ── MODALS ─────────────────────────────────────
  function openAddModal() {
    document.getElementById('editId').value = '';
    document.getElementById('modalTitle').textContent    = 'Add New Student';
    document.getElementById('modalSubtitle').textContent = "Fill in the student's details below";
    clearForm();
    document.getElementById('formOverlay').classList.add('open');
  }

  async function openEditModal(id) {
    const res  = await fetch(`api.php?action=read_one&id=${id}`);
    const json = await res.json();
    if (!json.success) { showToast('Could not load student data', 'error'); return; }
    const s = json.data;
    document.getElementById('editId').value       = s.id;
    document.getElementById('f_student_id').value = s.student_id;
    document.getElementById('f_first_name').value = s.first_name;
    document.getElementById('f_last_name').value  = s.last_name;
    document.getElementById('f_email').value      = s.email;
    document.getElementById('f_course').value     = s.course;
    document.getElementById('f_year_level').value = s.year_level;
    document.getElementById('f_gpa').value        = s.gpa;
    document.getElementById('modalTitle').textContent    = 'Edit Student Record';
    document.getElementById('modalSubtitle').textContent = `Editing: ${s.first_name} ${s.last_name}`;
    document.getElementById('formOverlay').classList.add('open');
  }

  function closeModal() { document.getElementById('formOverlay').classList.remove('open'); }

  // ── SAVE ───────────────────────────────────────
  async function saveStudent() {
    const id = document.getElementById('editId').value;
    const payload = {
      id:         id ? parseInt(id) : null,
      student_id: document.getElementById('f_student_id').value.trim(),
      first_name: document.getElementById('f_first_name').value.trim(),
      last_name:  document.getElementById('f_last_name').value.trim(),
      email:      document.getElementById('f_email').value.trim(),
      course:     document.getElementById('f_course').value.trim(),
      year_level: parseInt(document.getElementById('f_year_level').value),
      gpa:        parseFloat(document.getElementById('f_gpa').value || 0),
    };

    const required = ['student_id','first_name','last_name','email','course','year_level'];
    let valid = true;
    required.forEach(k => {
      const el = document.getElementById('f_' + k);
      if (!payload[k] || (typeof payload[k] === 'number' && isNaN(payload[k]))) {
        el.classList.add('input-error'); valid = false;
      } else { el.classList.remove('input-error'); }
    });
    if (!valid) { showToast('Please fill all required fields', 'error'); return; }

    const action = id ? 'update' : 'create';
    const res    = await fetch(`api.php?action=${action}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const json = await res.json();
    if (json.success) { showToast(json.message, 'success'); closeModal(); loadStudents(); }
    else { showToast(json.message, 'error'); }
  }

  // ── DELETE ─────────────────────────────────────
  function openDeleteModal(id, name) {
    deleteId = id;
    document.getElementById('deleteMsg').textContent = `"${name}" will be permanently removed from the system.`;
    document.getElementById('deleteOverlay').classList.add('open');
  }
  function closeDeleteModal() { document.getElementById('deleteOverlay').classList.remove('open'); deleteId = null; }

  async function confirmDelete() {
    if (!deleteId) return;
    const res  = await fetch('api.php?action=delete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: deleteId })
    });
    const json = await res.json();
    if (json.success) { showToast(json.message, 'success'); closeDeleteModal(); loadStudents(); }
    else { showToast(json.message, 'error'); }
  }

  // ── HELPERS ────────────────────────────────────
  function clearForm() {
    ['f_student_id','f_first_name','f_last_name','f_email','f_course','f_year_level','f_gpa']
      .forEach(id => { document.getElementById(id).value = ''; document.getElementById(id).classList.remove('input-error'); });
  }

  function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  let toastTimer;
  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    t.className = `show ${type}`;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.className = type, 3500);
  }

  document.getElementById('formOverlay').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
  document.getElementById('deleteOverlay').addEventListener('click', e => { if (e.target === e.currentTarget) closeDeleteModal(); });

  loadStudents();
</script>
</body>
</html>

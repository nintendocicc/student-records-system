<?php
// ============================================
//  api.php — CRUD REST-style Endpoint
// ============================================

header('Content-Type: application/json');

require_once 'db_connect.php';

$action = $_GET['action'] ?? '';
$conn   = getConnection();

switch ($action) {

    // ── READ: all students ──────────────────────
    case 'read':
        $search = $conn->real_escape_string($_GET['search'] ?? '');
        $sort   = in_array($_GET['sort'] ?? '', ['student_id', 'first_name', 'last_name', 'course', 'year_level', 'gpa'])
                  ? $_GET['sort'] : 'id';
        $dir    = ($_GET['dir'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        $where = $search
            ? "WHERE student_id LIKE '%$search%'
               OR first_name   LIKE '%$search%'
               OR last_name    LIKE '%$search%'
               OR email        LIKE '%$search%'
               OR course       LIKE '%$search%'"
            : '';

        $result   = $conn->query("SELECT * FROM students $where ORDER BY $sort $dir");
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $students, 'count' => count($students)]);
        break;

    // ── READ ONE: single student ─────────────────
    case 'read_one':
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row  = $stmt->get_result()->fetch_assoc();

        echo $row
            ? json_encode(['success' => true, 'data' => $row])
            : json_encode(['success' => false, 'message' => 'Student not found']);
        break;

    // ── CREATE: add student ──────────────────────
    case 'create':
        $data     = json_decode(file_get_contents('php://input'), true);
        $required = ['student_id', 'first_name', 'last_name', 'email', 'course', 'year_level'];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
                exit;
            }
        }

        $stmt = $conn->prepare(
            "INSERT INTO students (student_id, first_name, last_name, email, course, year_level, gpa)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $gpa = (float)($data['gpa'] ?? 0);
        $stmt->bind_param(
            'sssssid',
            $data['student_id'], $data['first_name'], $data['last_name'],
            $data['email'], $data['course'], $data['year_level'], $gpa
        );

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student added successfully', 'id' => $conn->insert_id]);
        } else {
            $msg = str_contains($conn->error, 'Duplicate')
                ? 'Student ID or Email already exists'
                : 'Failed to add student: ' . $conn->error;
            echo json_encode(['success' => false, 'message' => $msg]);
        }
        break;

    // ── UPDATE: edit student ─────────────────────
    case 'update':
        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Invalid student ID']);
            exit;
        }

        $stmt = $conn->prepare(
            "UPDATE students
             SET student_id=?, first_name=?, last_name=?, email=?, course=?, year_level=?, gpa=?
             WHERE id=?"
        );
        $gpa = (float)($data['gpa'] ?? 0);
        $stmt->bind_param(
            'sssssidi',
            $data['student_id'], $data['first_name'], $data['last_name'],
            $data['email'], $data['course'], $data['year_level'], $gpa, $id
        );

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student updated successfully']);
        } else {
            $msg = str_contains($conn->error, 'Duplicate')
                ? 'Student ID or Email already in use'
                : 'Failed to update: ' . $conn->error;
            echo json_encode(['success' => false, 'message' => $msg]);
        }
        break;

    // ── DELETE: remove student ───────────────────
    case 'delete':
        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Invalid student ID']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param('i', $id);

        echo $stmt->execute()
            ? json_encode(['success' => true, 'message' => 'Student deleted successfully'])
            : json_encode(['success' => false, 'message' => 'Failed to delete student']);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}

$conn->close();
?>

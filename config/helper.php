<?php
session_start();
require_once "config.php";

function __construct()
{
    session_start();
}

function connectDB() {

    global $DB_SETTING;
    
    $servername = $DB_SETTING['HOST'];
    $username = $DB_SETTING['USERNAME'];
    $password = $DB_SETTING['PASSWORD'];
    $dbname = $DB_SETTING['DATABASE'];

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}


function insertData($nama_tabel, $data) {
    $conn = connectDB();

    // Membuat query untuk insert
    $fields = implode(',', array_keys($data));
    $values = "'" . implode("','", array_values($data)) . "'";
    $sql = "INSERT INTO $nama_tabel ($fields) VALUES ($values)";

    if ($conn->query($sql) === TRUE) {
        return TRUE;
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


function updateData($nama_tabel, $data, $where) {
    $conn = connectDB();

    // Membuat query untuk update
    $update_fields = '';

    foreach ($data as $key => $value) {
        $update_fields .= "$key='$value',";
    }
    $update_fields = rtrim($update_fields, ',');

    $sql = "UPDATE $nama_tabel SET $update_fields WHERE $where";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diupdate";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function deleteData($nama_tabel, $where) {
    $conn = connectDB();

    // Membuat query untuk delete
    $sql = "DELETE FROM $nama_tabel WHERE $where";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function getDataResultArray($nama_tabel, $where = '') {
    $conn = connectDB();

    // Membuat query untuk select
    $sql = "SELECT * FROM $nama_tabel";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}

function getDataRowArray($nama_tabel, $where = '') {
    $conn = connectDB();

    // Membuat query untuk select
    $sql = "SELECT * FROM $nama_tabel";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();
    }

    $conn->close();
    return $data;
}

function base_url($path = '') {
    global $config;
    return $config['base_url'] . $path;
}

function site_url($files = '') {
    global $config;
    return $config['base_url'] . $files.'.php';
}

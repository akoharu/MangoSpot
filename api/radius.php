<?php
if(isset($_GET['data'])){
    $nas = DataTable("nas", "*", "identity = '$Menu[identity]' and users = '$Menu[id]'", 
        array("nasname", "shortname", "type", "ports", "id")
	);
	echo json_encode($nas, true);
}
if(isset($_GET['type'])){
    $type = array();
    $query_type = $Bsk->View("type", "id, name", "type = 'nas' and status = 'true'");
    foreach ($query_type as $show_type) {
        $type[] = $show_type;
    }
    echo json_encode($type ? 
		array("status" => true, "message" => "success", "data" => $type) : 
		array("status" => false, "message" => "error", "data" => false), true
	);
}
if(isset($_GET['detail'])){
    $id_detail = Rahmad($_GET['detail']);
    $query_detail = $Bsk->Tampil("nas", "*", "id = '$id_detail' and identity = '$Menu[identity]' and users = '$Menu[id]'");
    echo json_encode($query_detail ? 
		array("status" => true, "message" => "success", "data" => $query_detail) : 
		array("status" => false, "message" => "error", "data" => false), true
	);
}
if(isset($_POST['nasname'])){
    $id_post = Rahmad($_POST['id']);
    unset($_POST['id']);
    $check_post = $Bsk->Tampil("nas", "id", "id = '$id_post' and identity = '$Menu[identity]' and users = '$Menu[id]'");
    $data_post = array_replace(
        $_POST, 
        array("status" => (isset($_POST['status']) ? 'true' : 'false'))
    );
    $query_post = ($check_post ? 
        $Bsk->Ubah("nas", $data_post, "id = '$check_post[id]'") : 
        $Bsk->Tambah("nas", array_merge($data_post, array("identity" => $Menu['identity'], "users" => $Menu['id'])))
    );
    echo json_encode($query_post ? 
		array("status" => true, "message" => "success", "color" => "green", "data" => "Proccess data success") : 
		array("status" => false, "message" => "error", "color" => "red", "data" => "Proccess data failed!"), true
	);
}
if(isset($_POST['active'])){
    $id_active = Rahmad($_POST['active']);
    $check_active = $Bsk->Tampil("nas", "id, status", "id = '$id_active' and identity = '$Menu[identity]' and users = '$Menu[id]'");
    $query_active = $Bsk->Ubah(
        "nas", 
        array("status" => ($check_active['status'] ? 'false' : 'true')),
        "id = '$check_active[id]' "
    );
    echo json_encode($query_active ? 
		array("status" => true, "message" => "success", "color" => "green", "data" => "Active data success") : 
		array("status" => false, "message" => "error", "color" => "red", "data" => "Active data failed!"), true
	);
}
if(isset($_POST['delete'])){
    $query_delete = $Bsk->Hapus("nas", array("id" => Rahmad($_POST['delete']), "users" => $Menu['id']));
    echo json_encode($query_delete ? 
		array("status" => true, "message" => "success", "color" => "green", "data" => "Delete data success") : 
		array("status" => false, "message" => "error", "color" => "red", "data" => "Delete data failed!"), true
	);
}
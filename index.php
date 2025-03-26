<?php
 
header("Content-Type: application/json");
 
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);
 
$usuarios = [
    [ "id" => 1, "login" => "user1", "senha" => "1234", "nome" => "Usuário 1", "perfil" => "admin" ],
    [ "id" => 2, "login" => "user2", "senha" => "1234", "nome" => "Usuário 2", "perfil" => "user" ],
    [ "id" => 3, "login" => "user3", "senha" => "1234", "nome" => "Usuário 3", "perfil" => "user" ],
    [ "id" => 4, "login" => "user4", "senha" => "1234", "nome" => "Usuário 4", "perfil" => "user" ],
    [ "id" => 5, "login" => "user5", "senha" => "1234", "nome" => "Usuário 5", "perfil" => "user" ]
];
 
if ($method == 'POST') {
    if (!isset($data['login']) || !isset($data['senha'])) {
        echo json_encode(["erro" => "Login e senha são obrigatórios"]);
        http_response_code(400);
        exit;
    }
   
    $novoUsuario = [
        "id" => count($usuarios) + 1,
        "login" => $data['login'],
        "senha" => $data['senha'],
        "nome" => $data['nome'] ?? '',
        "perfil" => $data['perfil'] ?? ''
    ];
   
    $usuarios[] = $novoUsuario;
    echo json_encode($novoUsuario);
    http_response_code(201);
}
 
elseif ($method == 'GET') {
    echo json_encode(array_slice($usuarios, 0, 5));
}
 
elseif ($method == 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $query);
    if (!isset($query['id'])) {
        echo json_encode(["erro" => "ID é obrigatório"]);
        http_response_code(400);
        exit;
    }
   
    $id = (int) $query['id'];
    $usuarios = array_filter($usuarios, fn($user) => $user['id'] !== $id);
   
    echo json_encode(["mensagem" => "Usuário excluído com sucesso"]);
    http_response_code(200);
}
 
else {
    echo json_encode(["erro" => "Método não permitido"]);
    http_response_code(405);
}
?>
<?php
    include_once "../modelo/model_chat";

    //Conectar con el modelo de chat
    $chats = new Chat();
    
    //Array asociativo de la tabla chat
    $arrayChat = $chats->listar();
?>
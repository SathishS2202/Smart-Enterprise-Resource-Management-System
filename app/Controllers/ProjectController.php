<?php
$notificationModel->create([
    'user_id' => 1, // admin id
    'title' => 'New Project',
    'message' => 'Client created a new project: ' . $projectName,
    'type' => 'project'
]);

?>
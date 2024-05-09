<?php
require_once("includes/header.php");

// Start the session first
session_start();

try {
    // Begin a transaction
    $con->beginTransaction();

    // Prepare and execute the delete query for the users table
    $query_users = $con->prepare("DELETE FROM users WHERE username=:username");
    $query_users->bindValue(":username", $userLoggedIn);
    $query_users->execute();

    // Prepare and execute the delete query for the videoProgress table
    $query_videoProgress = $con->prepare("DELETE FROM videoProgress WHERE username=:username");
    $query_videoProgress->bindValue(":username", $userLoggedIn);
    $query_videoProgress->execute();

    // Prepare and execute the delete query for the billingDetails table
    $query_billingDetails = $con->prepare("DELETE FROM billingDetails WHERE username=:username");
    $query_billingDetails->bindValue(":username", $userLoggedIn);
    $query_billingDetails->execute();

    // Commit the transaction
    $con->commit();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit; // Ensure that script execution stops after the redirection
} catch (PDOException $e) {
    // Rollback the transaction in case of any error
    $con->rollBack();
    // Handle the exception (e.g., display an error message)
    echo "Error: " . $e->getMessage();
}
?>

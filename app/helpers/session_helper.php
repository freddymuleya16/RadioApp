<?php
session_start();
// Check Logged In
function isLoggedIn()
{
  if (isset($_SESSION['id'])) {
    return true;
  } else {
    return false;
  }
}
function isAdmin()
{
  if (isset($_SESSION['id']) && isset($_SESSION['status'])) {
    return true;
  } else {
    return false;
  }
}
function redirect($page)
{
  header('location: ' . URLROOT . $page);
}

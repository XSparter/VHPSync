## Introduction

This is an open-source project for a Video Management System. The system allows users to manage video files in two modes: "master" and "dependent". 

## Code Explanation

The project is primarily written in PHP. It consists of two main files: `index.php` and `iniupdater.php`.

`index.php` is the main file that displays the video files and controls the video player. It operates in two modes: "master" and "dependent". In "master" mode, the state of the video player (current time and pause status) is stored in an `.ini` file every second. In "dependent" mode, the state of the video player is synchronized with the state stored in the `.ini` file every second.

`iniupdater.php` is responsible for reading and writing the state of the video player to the `.ini` file. It provides two functions: `memorizzaStatoPlayer` for storing the state of the video player, and `ottieniStatoPlayer` for retrieving the state of the video player.

The state of the video player is stored in the format `current_time##is_paused`, where `current_time` is the current time of the video in seconds, and `is_paused` is a boolean value indicating whether the video is paused.

## Usage

To use the system, simply open `index.php` in a web browser. The page will display a list of video files. Click on the "Master" link to play a video in "master" mode, or the "Dependent" link to play a video in "dependent" mode.
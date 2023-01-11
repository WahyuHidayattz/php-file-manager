<?php

function deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

$path = "storage";
$show_view = false;
$file_name = '';
$upload_sucess = false;

if (!file_exists("storage")) {
    mkdir("storage");
}

if (isset($_GET['path'])) {
    $path = $_GET['path'];
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo 'File not found';
    }
}

if (isset($_POST["delete-folder"])) {
    $back_path = dirname($path);
    deleteDirectory($path);
    header("Location: {$_SERVER['PHP_SELF']}?path=$back_path");
}

if (isset($_FILES["upload"])) {
    $name = $_FILES["upload"]["name"];
    $tmp_name = $_FILES["upload"]["tmp_name"];
    $size = $_FILES["upload"]["size"];
    $error = $_FILES["upload"]["error"];
    if ($error == 0) {
        if (move_uploaded_file($tmp_name, $path . "/" . $name)) {
            $upload_sucess = true;
        }
    }
}

if (isset($_GET["remove"])) {
    unlink($_GET["remove"]);
    $n_dir = dirname($_GET["remove"]);
    header("Location: {$_SERVER['PHP_SELF']}?path=$n_dir");
}

if (isset($_POST["input-folder-name"])) {
    $folder_name = $path . "/" . $_POST["input-folder-name"];
    if (!file_exists($folder_name)) {
        mkdir($folder_name);
    }
}

$new_path = [];
foreach (scandir($path) as $file) {
    if ($file != ".") {
        if ($file == "..") {
            $new_path[] = [$file, "folder", "?path=" . dirname("$path")];
        } else if (is_dir("$path/$file")) {
            $new_path[] = [$file, "folder", "?path=$path/$file"];
        } else {
            $new_path[] = [$file, "file", "?file=$path/$file"];
        }
    }
}

array_multisort(
    array_column($new_path, 1),
    SORT_DESC,
    array_column($new_path, 0),
    SORT_ASC,
    $new_path
);

$dir_listing = explode("/", $path);
$dir_listing_new = [];
foreach ($dir_listing as $list) {
    if ($list != ".." && $list != ".") {
        $dir_listing_new[] = $list;
    }
}
array_shift($dir_listing_new);
$in_folder = true;

if (!$dir_listing_new) {
    $in_folder = false;
    array_shift($new_path);
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/app.css">
    <title>File Manager</title>
</head>

<body class="text-sm md:text-base">

    <!-- main container -->
    <div class="flex flex-col w-full h-full overflow-auto bg-gray-200">

        <!-- header -->
        <div class="flex flex-row items-center justify-between gap-6 px-4 py-4 text-white md:px-12 lg:px-24 bg-slate-900">
            <div class="flex flex-col">
                <span class="font-semibold">File Manager PHP</span>
                <span class="text-sm text-slate-400">Created by Wahyu Hidayat</span>
            </div>
        </div>
        <!-- content -->

        <div class="flex flex-col flex-1 px-4 py-6 overflow-auto md:px-12 lg:px-24">

            <div class="flex flex-col flex-1 overflow-auto bg-white rounded-md shadow-md">

                <div class="flex flex-row items-center justify-end gap-3 p-4 border-b md:justify-between border-b-gray-200">
                    <div class="flex-row items-center flex-1 hidden gap-2 py-3 overflow-auto text-sm md:flex">
                        <a href="?path=storage" class="flex flex-row px-2 py-1 font-semibold bg-blue-100 rounded-md hover:bg-blue-200 whitespace-nowrap">
                            Root Folder
                        </a>
                        <?php foreach ($dir_listing_new as $list) : ?>
                            <span class="flex flex-row px-2 py-1 bg-gray-200 rounded-md whitespace-nowrap"><?= $list; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <button id="button-file-upload" class="flex items-center justify-center flex-row gap-3 px-3 py-1.5 bg-blue-500 hover:bg-blue-400 text-white rounded-md shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M9.25 13.25a.75.75 0 001.5 0V4.636l2.955 3.129a.75.75 0 001.09-1.03l-4.25-4.5a.75.75 0 00-1.09 0l-4.25 4.5a.75.75 0 101.09 1.03L9.25 4.636v8.614z" />
                            <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                        </svg>
                        <span>Upload File</span>
                    </button>
                    <button id="button-create-folder" class="flex items-center justify-center flex-row gap-3 px-3 py-1.5 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M3.75 3A1.75 1.75 0 002 4.75v10.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0018 15.25v-8.5A1.75 1.75 0 0016.25 5h-4.836a.25.25 0 01-.177-.073L9.823 3.513A1.75 1.75 0 008.586 3H3.75zM10 8a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5A.75.75 0 0110 8z" clip-rule="evenodd" />
                        </svg>
                        <span>Create Folder</span>
                    </button>
                </div>

                <?php if ($upload_sucess) : ?>
                    <div class="flex flex-row items-center justify-between px-4 text-sm text-blue-500 bg-blue-100">
                        <span>Upload file sucess.</span>
                        <a href="" class="p-2 rounded-full hover:bg-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col h-full overflow-auto">
                    <div class="flex flex-col gap-3 p-6 sm:grid sm:grid-cols-2 md:grid md:grid-cols-3 lg:grid lg:grid-cols-4 xl:grid xl:grid-cols-5">
                        <?php foreach ($new_path as $file) : ?>
                            <div class="flex flex-row items-center justify-between flex-1 w-full overflow-hidden text-gray-700 bg-white border border-gray-300 rounded-md ">
                                <a href="<?= $file[2]; ?>" class="flex flex-row items-center flex-1 w-full gap-3 px-4 py-3 overflow-hidden hover:bg-gray-100">
                                    <?php if ($file[1] == "folder") : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M3.75 3A1.75 1.75 0 002 4.75v3.26a3.235 3.235 0 011.75-.51h12.5c.644 0 1.245.188 1.75.51V6.75A1.75 1.75 0 0016.25 5h-4.836a.25.25 0 01-.177-.073L9.823 3.513A1.75 1.75 0 008.586 3H3.75zM3.75 9A1.75 1.75 0 002 10.75v4.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0018 15.25v-4.5A1.75 1.75 0 0016.25 9H3.75z" />
                                        </svg>
                                    <?php else : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-500">
                                            <path d="M3 3.5A1.5 1.5 0 014.5 2h6.879a1.5 1.5 0 011.06.44l4.122 4.12A1.5 1.5 0 0117 7.622V16.5a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 013 16.5v-13z" />
                                        </svg>
                                    <?php endif; ?>
                                    <span class="flex-1 overflow-hidden whitespace-nowrap text-ellipsis">
                                        <?= $file[0]; ?>
                                    </span>
                                </a>
                                <?php if ($file[1] == "file") : ?>
                                    <a href="?remove=<?= $path . "/" . $file[0]; ?>" name="delete-file" class="h-full px-3 py-1.5 hover:bg-red-100 group items-center justify-center flex flex-col">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 group-hover:text-red-500">
                                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($in_folder) : ?>
                    <form action="" method="post" class="flex flex-row items-center justify-end gap-3 p-4 m-0 border-t border-t-gray-200 ">
                        <button name="delete-folder" class="flex items-center justify-center flex-row gap-3 px-3 py-1.5 bg-red-500 text-white rounded-md shadow-md hover:bg-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Delete and Empty this folder</span>
                        </button>
                    </form>
                <?php endif; ?>

            </div>

            <!-- modal dialgo upload -->
            <form action="" method="post" enctype="multipart/form-data" id="modal-file-upload" class="hidden w-[300px] md:w-[350px] absolute top-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg mt-[180px] mr-8 md:mr-16 lg:mr-28 w-[350px] flex flex-col gap-4 overflow-hidden">
                <div class="flex flex-row items-center justify-between gap-4 px-4 py-2 border-b border-b-gray-300">
                    <span>File Uploader</span>
                    <div id="button-file-close" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 px-4">
                    <input type="file" name="upload" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                </div>
                <button name="submit" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-400">Upload All Files</button>
            </form>

            <!-- modal dialgo create folder -->
            <form action="" method="post" id="modal-create-folder" class="hidden absolute top-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg mt-[180px] mr-8 md:mr-16 lg:mr-28 w-[300px] md:w-[350px] flex flex-col gap-4 overflow-hidden">
                <div class="flex flex-row items-center justify-between gap-4 px-4 py-2 border-b border-b-gray-300">
                    <span>Create Folder</span>
                    <div id="button-create-folder-close" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 px-4">
                    <input type="text" name="input-folder-name" class="px-3 py-2 pr-4 text-sm bg-gray-100 border-b border-b-2 outline-none border-b-gray-300 file:text-blue-500 hover:border-b-blue-500 text-slate-700 focus:border-b-blue-500" placeholder="folder name">
                </div>
                <button name="submit" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-400">Create Folder</button>
            </form>

        </div>

    </div>

</body>

<script>
    let button_file_upload = document.getElementById("button-file-upload");
    let button_file_upload_close = document.getElementById("button-file-close");
    let modal_file_upload = document.getElementById("modal-file-upload");

    button_file_upload.addEventListener('click', function(event) {
        event.preventDefault();
        modal_file_upload.classList.toggle("hidden");
    })
    button_file_upload_close.addEventListener('click', (event) => {
        modal_file_upload.classList.toggle("hidden");
    })

    let button_create_folder = document.getElementById("button-create-folder");
    let modal_create_folder = document.getElementById("modal-create-folder");
    let button_create_folder_close = document.getElementById("button-create-folder-close")

    button_create_folder.addEventListener('click', (event) => {
        event.preventDefault();
        modal_create_folder.classList.toggle("hidden");
    })

    button_create_folder_close.addEventListener('click', () => {
        modal_create_folder.classList.toggle("hidden");
    })
</script>

</html>
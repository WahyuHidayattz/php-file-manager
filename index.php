<?php

$files = [];
$in_folder = false;
for ($i = 0; $i < 100; $i++) {
    if ($i % 2 == 0) {
        $files[] = ["This is Folder", "folder"];
    } else {
        $files[] = ["This is Files", "file"];
    }
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

<body class="">

    <!-- main container -->
    <div class="flex flex-col w-full h-full bg-gray-200 overflow-auto">

        <!-- header -->
        <div class="flex flex-row items-center justify-between gap-6 px-4 md:px-12 lg:px-24 py-4 bg-slate-900 text-white">
            <div class="flex flex-col">
                <span class="font-semibold">File Manager PHP</span>
                <span class="text-sm text-slate-400">Created by Wahyu Hidayat</span>
            </div>
        </div>
        <!-- content -->

        <div class="flex flex-col px-4 md:px-12 lg:px-24 py-6 flex-1 overflow-auto">

            <div class="flex flex-col bg-white shadow-md rounded-md overflow-auto flex-1">

                <div class="flex flex-row md:justify-between justify-end items-center gap-3 p-4 border-b border-b-gray-200">
                    <div class="hidden md:flex flex-1 flex-row items-center gap-2 text-sm">
                        <a href="" class="flex flex-row px-2 py-1 bg-blue-100 hover:bg-blue-200 rounded-md font-semibold">
                            Root Folder
                        </a>
                        <a href="" class="flex flex-row px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded-md">Wahyu</a>
                        <a href="" class="flex flex-row px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded-md">Hidayat</a>
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

                <div class="flex flex-col sm:grid sm:grid-cols-2 md:grid md:grid-cols-3 lg:grid lg:grid-cols-4 xl:grid xl:grid-cols-5 gap-3 p-6 overflow-auto">
                    <?php foreach ($files as $file) : ?>
                        <a href="" class="w-full flex flex-row items-center gap-4 px-6 py-3 text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-200">
                            <?php if ($file[1] == "file") : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                                </svg>
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M3.75 3A1.75 1.75 0 002 4.75v3.26a3.235 3.235 0 011.75-.51h12.5c.644 0 1.245.188 1.75.51V6.75A1.75 1.75 0 0016.25 5h-4.836a.25.25 0 01-.177-.073L9.823 3.513A1.75 1.75 0 008.586 3H3.75zM3.75 9A1.75 1.75 0 002 10.75v4.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0018 15.25v-4.5A1.75 1.75 0 0016.25 9H3.75z" />
                                </svg>
                            <?php endif; ?>
                            <?= $file[0]; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php if ($in_folder) : ?>
                    <div class="flex flex-row justify-end items-center gap-3 p-4 border-t border-t-gray-200">
                        <a href="" class="flex items-center justify-center flex-row gap-3 px-3 py-1.5 bg-red-500 text-white rounded-md shadow-md hover:bg-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Delete This Folder</span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- modal dialgo upload -->
            <div id="modal-file-upload" class="hidden absolute top-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg mt-[180px] mr-8 md:mr-16 lg:mr-28 w-[350px] flex flex-col gap-4 overflow-hidden">
                <div class="flex flex-row items-center justify-between gap-4 border-b border-b-gray-300 px-4 py-2">
                    <span>File Uploader</span>
                    <div id="button-file-close" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 px-4">
                    <input type="file" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                    <input type="file" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                    <input type="file" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                    <input type="file" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                    <input type="file" class="pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100 file:px-3 file:py-1.5 file:outline-none file:border-none file:bg-blue-200 file:text-blue-500 hover:border-b-blue-500 cursor-pointer text-slate-700">
                </div>
                <button class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-400">Upload All Files</button>
            </div>

            <!-- modal dialgo create folder -->
            <div id="modal-create-folder" class="hidden absolute top-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg mt-[180px] mr-8 md:mr-16 lg:mr-28 w-[350px] flex flex-col gap-4 overflow-hidden">
                <div class="flex flex-row items-center justify-between gap-4 border-b border-b-gray-300 px-4 py-2">
                    <span>Create Folder</span>
                    <div id="button-create-folder-close" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 px-4">
                    <input type="text" class="px-3 py-2 pr-4 text-sm border-b border-b-2 border-b-gray-300 bg-gray-100  file:text-blue-500 hover:border-b-blue-500  text-slate-700 outline-none focus:border-b-blue-500" placeholder="folder name">
                </div>
                <button class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-400">Upload All Files</button>
            </div>

        </div>

    </div>

</body>

<script>
    let button_file_upload = document.getElementById("button-file-upload");
    let button_file_upload_close = document.getElementById("button-file-close");
    let modal_file_upload = document.getElementById("modal-file-upload");

    button_file_upload.addEventListener('click', function(event){
        event.preventDefault();
        modal_file_upload.classList.toggle("hidden");
    })
    button_file_upload_close.addEventListener('click', (event)=> {
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
<div id="upload-Modal" class="modal-overlay hidden">
    <div id="custom-modal" class="rounded-lg shadow-xl flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-xl font-bold">Unggah Dokumen</h2>
        </div>

        <!-- Content -->
        <div class="p-6 flex">
            <!-- Drag and Drop Area -->
            <div id="dropZone" class="border-2 border-dashed border-orange-400 h-[180px] w-1/2 flex flex-col items-center justify-center mb-4 bg-gray-50 flex-shrink-0">
                <div class="text-center">
                    <p class="text-orange-500 text-sm font-semibold mb-1">Tarik files ke sini</p>
                    <p class="text-gray-500 text-sm my-1">Atau</p>
                    <input type="file" id="fileInput" class="hidden" accept=".pdf" multiple />
                    <button class="text-orange-600 underline text-sm mt-1" onclick="document.getElementById('fileInput').click();">
                        Jelajahi
                    </button>
                </div>
            </div>

            <!-- File List (Displayed on the right) -->
            <div id="fileListContainer">
                <ul id="fileList">
                </ul>
            </div>
        </div>

        <div class="p-4 flex justify-end items-center space-x-2">
            <button class="btn-orange" onclick="closeModal('editPengajuanModal')">
                Batalkan
            </button>
            <button class="btn-blue" onclick="saveFiles();">
                Simpan
            </button>
        </div>
    </div>
</div>

<script>
    let selectedFiles = []; // Array to store selected or dropped files

    // Handle files selected via "Jelajahi" button
    document.getElementById('fileInput').addEventListener('change', function(event) {
        handleFiles(event.target.files);
        this.value = ''; // Reset the input so same file can be uploaded again
    });

    // Handle drag-and-drop functionality
    const dropZone = document.getElementById('dropZone');

    dropZone.addEventListener('dragover', function(event) {
        event.preventDefault();
        dropZone.classList.add('bg-orange-100'); // Optional: change background color on hover
    });

    dropZone.addEventListener('dragleave', function(event) {
        event.preventDefault();
        dropZone.classList.remove('bg-orange-100');
    });

    dropZone.addEventListener('drop', function(event) {
        event.preventDefault();
        dropZone.classList.remove('bg-orange-100');
        const files = event.dataTransfer.files;
        handleFiles(files); // Handle dropped files
    });

    // Function to handle displaying files in the list
    function handleFiles(files) {
        const fileListElement = document.getElementById('fileList');

        Array.from(files).forEach(file => {
            if (file.type === 'application/pdf') { // Only allow PDF files
                if (!selectedFiles.some(f => f.name === file.name)) { // Only add if file is not already selected
                    selectedFiles.push(file); // Add the file to the array

                    const li = document.createElement('li');
                    li.classList.add('flex', 'justify-between', 'items-center', 'p-2');

                    // Create PDF icon
                    const img = document.createElement('img');
                    img.src = '/assets/img/pdf.png'; // Update to actual path
                    img.alt = 'PDF Icon';
                    img.classList.add('w-6', 'h-6', 'mr-2');

                    // File name
                    const fileName = document.createElement('span');
                    fileName.textContent = file.name;
                    fileName.classList.add('text-xs', 'mr-2', 'flex-shrink-0');

                    // Delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('text-red-500');
                    deleteButton.innerHTML = '&times;';
                    deleteButton.onclick = () => {
                        li.remove(); // Remove file from the list
                        selectedFiles = selectedFiles.filter(f => f.name !== file.name); // Remove file from array
                    };

                    // Append to the list item
                    li.appendChild(img);
                    li.appendChild(fileName);
                    li.appendChild(deleteButton);

                    // Append the list item to the file list
                    fileListElement.appendChild(li);
                }
            } else {
                alert("Hanya file PDF yang diperbolehkan");
            }
        });
    }

    // Save Files function (simulation)
    function saveFiles() {
        if (selectedFiles.length > 0) {
            closeModal(); // Close the modal after saving
        } else {
            alert('Tidak ada file untuk disimpan.');
        }
    }

    // Reset Files function for "Batalkan"
    function resetFiles() {
        selectedFiles = []; // Clear the selected files array
        const fileListElement = document.getElementById('fileList');
        fileListElement.innerHTML = ''; // Clear the file list UI
    }

    function openModal() {
        document.getElementById('upload-Modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('upload-Modal').classList.add('hidden');
    }
</script>
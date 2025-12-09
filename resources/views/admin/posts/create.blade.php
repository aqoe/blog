@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Новый пост</h1>

    <form id="postForm" action="{{ route('admin.posts.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Заголовок</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Категория</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Без категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Краткое описание</label>
            <textarea name="excerpt" rows="2"
                      class="w-full border rounded px-3 py-2">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Содержание</label>
            <div class="border rounded bg-gray-50">
                <div id="toolbar" class="border-b bg-white p-2 flex flex-wrap gap-1">
                    <button type="button" onclick="addBlock('header')" class="px-3 py-1 border rounded hover:bg-gray-100">H</button>
                    <button type="button" onclick="addBlock('text')" class="px-3 py-1 border rounded hover:bg-gray-100">T</button>
                    <button type="button" onclick="addBlock('image')" class="px-3 py-1 border rounded hover:bg-gray-100">🖼️</button>
                    <button type="button" onclick="addBlock('quote')" class="px-3 py-1 border rounded hover:bg-gray-100">❝</button>
                    <button type="button" onclick="addBlock('divider')" class="px-3 py-1 border rounded hover:bg-gray-100">―</button>
                </div>
                <div id="editor" class="min-h-64 p-4 space-y-4">
                    <div class="text-gray-400 text-center py-8" id="placeholder">
                        Нажмите на кнопку выше, чтобы добавить блок
                    </div>
                </div>
            </div>
            <input type="hidden" name="content" id="content">
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" class="mr-2">
                <span class="text-gray-700">Опубликовать сразу</span>
            </label>
        </div>

        <div class="flex space-x-4">
            <button type="button" onclick="savePost()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Создать
            </button>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:underline py-2">
                Отмена
            </a>
        </div>
    </form>

    <!-- Скрытый input для загрузки изображений -->
    <input type="file" id="imageInput" accept="image/*" class="hidden">

    <script>
        let blocks = [];
        let currentImageBlockId = null;

        function addBlock(type) {
            document.getElementById('placeholder').style.display = 'none';
            
            const blockId = 'block-' + Date.now();
            const editor = document.getElementById('editor');
            
            let blockHtml = '';
            
            switch(type) {
                case 'header':
                    blockHtml = `
                        <div class="block-item" data-type="header" data-id="${blockId}">
                            <div class="flex gap-2 mb-1">
                                <select onchange="updateBlockData('${blockId}')" class="text-sm border rounded px-2 py-1" id="${blockId}-level">
                                    <option value="2">H2</option>
                                    <option value="3">H3</option>
                                    <option value="4">H4</option>
                                </select>
                                <button type="button" onclick="removeBlock('${blockId}')" class="text-red-500 text-sm">✕</button>
                            </div>
                            <input type="text" id="${blockId}-text" placeholder="Заголовок..." 
                                   class="w-full text-xl font-semibold border-b border-gray-200 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                    `;
                    break;
                    
                case 'text':
                    blockHtml = `
                        <div class="block-item" data-type="paragraph" data-id="${blockId}">
                            <div class="flex justify-between mb-1">
                                <div class="flex gap-1">
                                    <button type="button" onclick="formatText('${blockId}', 'bold')" class="px-2 py-1 border rounded text-sm hover:bg-gray-100"><b>B</b></button>
                                    <button type="button" onclick="formatText('${blockId}', 'italic')" class="px-2 py-1 border rounded text-sm hover:bg-gray-100"><i>I</i></button>
                                    <button type="button" onclick="formatText('${blockId}', 'link')" class="px-2 py-1 border rounded text-sm hover:bg-gray-100">🔗</button>
                                    <button type="button" onclick="formatText('${blockId}', 'tooltip')" class="px-2 py-1 border rounded text-sm hover:bg-gray-100">💬</button>
                                </div>
                                <button type="button" onclick="removeBlock('${blockId}')" class="text-red-500 text-sm">✕</button>
                            </div>
                            <textarea id="${blockId}-text" placeholder="Текст..." rows="3"
                                      class="w-full border rounded p-2 focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                    `;
                    break;
                    
                case 'image':
                    blockHtml = `
                        <div class="block-item" data-type="image" data-id="${blockId}">
                            <div class="flex justify-between mb-2">
                                <div class="flex gap-2 items-center">
                                    <select id="${blockId}-size" class="text-sm border rounded px-2 py-1">
                                        <option value="small">Маленькая</option>
                                        <option value="medium" selected>Средняя</option>
                                        <option value="large">Большая</option>
                                        <option value="full">Во всю ширину</option>
                                    </select>
                                </div>
                                <button type="button" onclick="removeBlock('${blockId}')" class="text-red-500 text-sm">✕</button>
                            </div>
                            <div id="${blockId}-preview" class="border-2 border-dashed border-gray-300 rounded p-8 text-center cursor-pointer hover:border-blue-500"
                                 onclick="selectImage('${blockId}')">
                                <div class="text-gray-400">Нажмите, чтобы выбрать изображение</div>
                            </div>
                            <input type="hidden" id="${blockId}-url">
                            <input type="text" id="${blockId}-caption" placeholder="Подпись к изображению (необязательно)"
                                   class="w-full border rounded px-3 py-2 mt-2 text-sm">
                        </div>
                    `;
                    break;
                    
                case 'quote':
                    blockHtml = `
                        <div class="block-item" data-type="quote" data-id="${blockId}">
                            <div class="flex justify-end mb-1">
                                <button type="button" onclick="removeBlock('${blockId}')" class="text-red-500 text-sm">✕</button>
                            </div>
                            <div class="border-l-4 border-gray-300 pl-4">
                                <textarea id="${blockId}-text" placeholder="Цитата..." rows="2"
                                          class="w-full italic focus:outline-none"></textarea>
                                <input type="text" id="${blockId}-caption" placeholder="— Автор"
                                       class="w-full text-sm text-gray-500 mt-2 focus:outline-none">
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'divider':
                    blockHtml = `
                        <div class="block-item" data-type="delimiter" data-id="${blockId}">
                            <div class="flex justify-center items-center gap-4">
                                <div class="flex-1 text-center text-gray-300 text-2xl">• • •</div>
                                <button type="button" onclick="removeBlock('${blockId}')" class="text-red-500 text-sm">✕</button>
                            </div>
                        </div>
                    `;
                    break;
            }
            
            const div = document.createElement('div');
            div.innerHTML = blockHtml;
            editor.appendChild(div.firstElementChild);
            
            blocks.push({ id: blockId, type: type });
        }

        function removeBlock(blockId) {
            const block = document.querySelector(`[data-id="${blockId}"]`);
            if (block) block.remove();
            blocks = blocks.filter(b => b.id !== blockId);
            
            if (blocks.length === 0) {
                document.getElementById('placeholder').style.display = 'block';
            }
        }

        function selectImage(blockId) {
            currentImageBlockId = blockId;
            document.getElementById('imageInput').click();
        }

        document.getElementById('imageInput').addEventListener('change', async function(e) {
            if (!e.target.files[0] || !currentImageBlockId) return;
            
            const formData = new FormData();
            formData.append('image', e.target.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            
            const preview = document.getElementById(currentImageBlockId + '-preview');
            preview.innerHTML = '<div class="text-gray-400">Загрузка...</div>';
            
            try {
                const response = await fetch('/admin/upload-image', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById(currentImageBlockId + '-url').value = data.file.url;
                    preview.innerHTML = `<img src="${data.file.url}" class="max-h-48 mx-auto rounded">`;
                } else {
                    preview.innerHTML = '<div class="text-red-500">Ошибка загрузки</div>';
                }
            } catch (error) {
                preview.innerHTML = '<div class="text-red-500">Ошибка загрузки</div>';
            }
            
            e.target.value = '';
        });

        function formatText(blockId, format) {
            const textarea = document.getElementById(blockId + '-text');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const selected = text.substring(start, end);
            
            if (!selected) {
                alert('Сначала выделите текст');
                return;
            }
            
            let formatted = '';
            
            switch(format) {
                case 'bold':
                    formatted = `<b>${selected}</b>`;
                    break;
                case 'italic':
                    formatted = `<i>${selected}</i>`;
                    break;
                case 'link':
                    const url = prompt('Введите URL:');
                    if (url) formatted = `<a href="${url}">${selected}</a>`;
                    else return;
                    break;
                case 'tooltip':
                    const tooltip = prompt('Введите текст подсказки:');
                    if (tooltip) formatted = `<span data-tooltip="${tooltip}">${selected}</span>`;
                    else return;
                    break;
            }
            
            textarea.value = text.substring(0, start) + formatted + text.substring(end);
        }

        function savePost() {
            const contentBlocks = [];
            
            document.querySelectorAll('.block-item').forEach(block => {
                const type = block.dataset.type;
                const id = block.dataset.id;
                
                let blockData = { type: type, data: {} };
                
                switch(type) {
                    case 'header':
                        blockData.data = {
                            text: document.getElementById(id + '-text').value,
                            level: parseInt(document.getElementById(id + '-level').value)
                        };
                        break;
                    case 'paragraph':
                        blockData.data = {
                            text: document.getElementById(id + '-text').value
                        };
                        break;
                    case 'image':
                        blockData.data = {
                            file: { url: document.getElementById(id + '-url').value },
                            caption: document.getElementById(id + '-caption').value,
                            size: document.getElementById(id + '-size').value
                        };
                        break;
                    case 'quote':
                        blockData.data = {
                            text: document.getElementById(id + '-text').value,
                            caption: document.getElementById(id + '-caption').value
                        };
                        break;
                    case 'delimiter':
                        break;
                }
                
                contentBlocks.push(blockData);
            });
            
            document.getElementById('content').value = JSON.stringify({ blocks: contentBlocks });
            document.getElementById('postForm').submit();
        }
    </script>

    <style>
        .block-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
        }
        .block-item:hover {
            border-color: #3b82f6;
        }
    </style>
@endsection
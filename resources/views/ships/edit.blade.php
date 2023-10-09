@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <h1>Редактировать корабль</h1>
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show">
                            @foreach ($errors->all() as $error)
                                <span><p>{{ $error }}</p></span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (session('success'))
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                <h4>Название:</h4>
                <form id="shipForm" action="/ships/{{ $ship->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input class="form-control" name='title' type="text" value="{{ $ship->title }}">
                    <input id="ship_description" name="description" type="hidden" value="">
                    <input id="ship_spec" name="spec" type="hidden" value="">
                    <input id="ship_cabins" name="cabins" type="hidden" value="">
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6 h-100">
                <h4>Описание:</h4>
                <div id="shipDescription">{!! $ship->description !!}</div>
            </div>
            <div class="col-6 container-fluid">
                <h4>Спецификации:</h4>
                <div id="specEditor">
                </div>
                <button class="btn btn-primary mt-3" id="addPair_btn" onclick="addPair()">Добавить параметр</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <h4>Категории кают:<button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#cabinModal" onclick="addCabin()">Добавить категорию</button></h4>
            <div id="cabinsContainer">
                @foreach($categories as $category)
                    <div class="cabin float-start border p-3 me-3 mb-3">
                        <input type="hidden" class="cabinId" value="{{ $category->id }}">
                        @if (sizeof($category->photos) === 0)
                            <div class="photo align-items-center d-flex" id="cabin_photo_{{ $category->id }}"><span class="mx-auto">Нет фотографии</span></div>
                        @else
                            <div class="photo align-items-center d-flex" style="background-image: url('{{ $category->photos[0] }}');" id="cabin_photo_{{ $category->id }}"><span class="bg-light px-2">{{ sizeof($category->photos) }}</span></div>
                        @endif
                        <div class="my-3 text-truncate" id="cabin_title_{{ $category->id }}">{{ $category->vendor_code }} - {{ $category->title }}</div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cabinModal" onclick="editCabin('{{ $category->id }}')">Изменить</button>
                        <button class="btn btn-danger" onclick="deleteCabin('{{ $category->id }}')">Удалить</button>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <h4>Галерея:</h4>
            <div id="galleryEditor">
            @foreach($gallery as $item)
                <div class="gallery_item float-start border p-3 me-3 mb-3" style="width: 250px;">
                    <div class="photo" style="background-image: url('{{ $item->url }}');"></div>
                    <div class="mt-3 text-truncate">{{ $item->title }}</div>
                </div>
            @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12"><button class="btn btn-primary" onclick="sendForm()">Сохранить изменения</button></div>
        </div>
    </div>

<div class="modal fade" id="cabinModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cabinModalLabel">Категория каюты</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="clearCabinForm()"></button>
            </div>
            <div class="modal-body container-fluid">
                <div class="row">
                    <div class="col-6">
                        <input type="hidden" id="editCabinId" value="0">
                        <h4>Назнание:</h4>
                        <input class="form-control" type="text" id="editCabinTitle">
                    </div>
                    <div class="col-3">
                        <h4>Vendor code:</h4>
                        <input class="form-control" type="text" id="editCabinVendor">
                    </div>
                    <div class="col-3">
                        <h4>Тип:</h4>
                        <select class="form-select" id="editCabinType">
                            <option value="Inside">Inside</option>
                            <option value="Ocean view">Ocean view</option>
                            <option value="Balcony">Balcony</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 h-100">
                        <h4>Описание:</h4>
                        <span id="contentDescription">
                            <div id="cabinDescription"></div>
                        </span>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12">
                        <h4>Фото:</h4>
                        <input class="form-control" type="text" id="editCabinPhoto">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearCabinForm()">Отмена</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="saveCabin()">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    let added_counter = 0;
    let cabinDescriptionEditor;
    let jsonData = @php echo json_encode($ship->spec); @endphp;
    let cabinsData = @php echo $categories; @endphp;
    function generateEditor() {
        const editorDiv = document.getElementById('specEditor');
        editorDiv.innerHTML = '';

        for (let i = 0; i < jsonData.length; i++) {
            const pair = jsonData[i];
            const dragHandle = '<div class="col-1"><div class="h-100 align-items-center d-flex drag-handle"><span class="mx-auto">↑↓</span></div></div>';
            const nameInput = `<div class="col-4"><input type="text" class="form-control name-input" value="${pair.name}" placeholder="Name"></div>`;
            const valueInput = `<div class="col-4"><input type="text" class="form-control value-input" value="${pair.value}" placeholder="Value"></div>`;
            const removeButton = `<div class="col-3"><button class="btn btn-danger" onclick="removePair(${i})">Удалить</button></div>`;

            const pairDiv = document.createElement('div');
            pairDiv.className = 'pair row py-2';
            pairDiv.innerHTML = dragHandle + nameInput + valueInput + removeButton;

            editorDiv.appendChild(pairDiv);
        }

        const sortable = new Sortable(editorDiv, {
            handle: '.drag-handle',
            ghostClass: 'ghost',
            animation: 150,
            onUpdate: function (evt) {
                updateDataFromUI();
            }
        });
    }

    function addPair() {
        const newPair = {
            name: '',
            value: ''
        };

        jsonData.push(newPair);
        generateEditor();
    }

    function removePair(index) {
        jsonData.splice(index, 1);
        generateEditor();
    }

    function updateDataFromUI() {
        const pairs = document.querySelectorAll('.pair');
        jsonData = [];
        pairs.forEach(function(pairDiv, index) {
            const name = pairDiv.querySelector('.name-input').value;
            const value = pairDiv.querySelector('.value-input').value;
            jsonData.push({ name, value });
        });
    }

    function updateData() {
        updateDataFromUI();
    }

    const cabin_sortable = new Sortable(cabinsContainer, {
        handle: '.cabin',
        ghostClass: 'ghost',
        animation: 150,
        onUpdate: function (evt) {
            cabinsReorder();
        }
    });

    function cabinsReorder() {
        const cabinsIds = document.querySelectorAll('.cabinId');
        for (let i = 0; i < cabinsIds.length; i++) {
            let id = cabinsIds[i].value;
            for (let j = 0; j < cabinsData.length; j++) {
                if (cabinsData[j].id == id) cabinsData[j].ordering = i;
                if (cabinsData[j].action !== 'added' && cabinsData[j].action !== 'deleted') cabinsData[j].action = 'updated';
            }
        }
    }

    function deleteCabin(id) {
        const cabinsIds = document.querySelectorAll('.cabinId');
        for (let i = 0; i < cabinsIds.length; i++) {
            if (cabinsIds[i].value == id) {
                cabinsIds[i].parentElement.remove();
            }
        }
        for (let i = 0; i < cabinsData.length; i++) {
            if (cabinsData[i].id == id) {
                if (cabinsData[i].action === 'added') cabinsData.splice(i, 1);
                else cabinsData[i].action = 'deleted';
            }
        }
    }

    function addCabin() {
        document.getElementById('editCabinId').value = '0';
        document.getElementById('contentDescription').innerHTML = '<div id="cabinDescription"></div>';
        cabinDescriptionEditor = new Quill('#cabinDescription', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    }

    function editCabin(id) {
        for (let i = 0; i < cabinsData.length; i++) {
            if (cabinsData[i].id == id) {
                document.getElementById('editCabinId').value = cabinsData[i].id;
                document.getElementById('editCabinTitle').value = cabinsData[i].title;
                document.getElementById('editCabinVendor').value = cabinsData[i].vendor_code;
                document.getElementById('editCabinType').value = cabinsData[i].type;
                document.getElementById('contentDescription').innerHTML = '<div id="cabinDescription">'+cabinsData[i].description+'</div>';
                cabinDescriptionEditor = new Quill('#cabinDescription', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow'
                });
                if (cabinsData[i].photos[0]) document.getElementById('editCabinPhoto').value = cabinsData[i].photos[0];
            }
        }
    }

    function clearCabinForm() {
        document.getElementById('editCabinId').value = '';
        document.getElementById('editCabinTitle').value = '';
        document.getElementById('editCabinVendor').value = '';
        document.getElementById('editCabinType').value = 'Inside';
        document.getElementById('contentDescription').innerHTML = '';
        document.getElementById('editCabinPhoto').value = '';
    }

    function saveCabin() {
        let id = document.getElementById('editCabinId').value;
        if (id != 0) {
            for (let i = 0; i < cabinsData.length; i++) {
                if (cabinsData[i].id == id) {
                    cabinsData[i].title = document.getElementById('editCabinTitle').value;
                    cabinsData[i].vendor_code = document.getElementById('editCabinVendor').value;
                    document.getElementById('cabin_title_' + id).innerHTML = cabinsData[i].vendor_code + ' - ' + cabinsData[i].title;
                    cabinsData[i].type = document.getElementById('editCabinType').value;
                    cabinsData[i].description = cabinDescriptionEditor.getHtml();
                    if (document.getElementById('editCabinPhoto').value !== '') {
                        cabinsData[i].photos[0] = document.getElementById('editCabinPhoto').value;
                        document.getElementById('cabin_photo_' + id).style.backgroundImage = "url('" + cabinsData[i].photos[0] + "')";
                        document.getElementById('cabin_photo_' + id).innerHTML = '<span class="bg-light px-2">' + cabinsData[i].photos.length + '</span>';
                    } else {
                        cabinsData[i].photos = [];
                        document.getElementById('cabin_photo_' + id).style.backgroundImage = "";
                        document.getElementById('cabin_photo_' + id).innerHTML = '<span class="mx-auto">Нет фотографии</span>';
                    }
                    if (!cabinsData[i].action) cabinsData[i].action = 'updated';
                }
            }
        } else {
            const newCabin = {
                id: 'added' + added_counter,
                ship_id: {{ $ship->id }},
                vendor_code: document.getElementById('editCabinVendor').value,
                title: document.getElementById('editCabinTitle').value,
                type: document.getElementById('editCabinType').value,
                description: cabinDescriptionEditor.getHtml(),
                photos: document.getElementById('editCabinPhoto').value === '' ? [] : [document.getElementById('editCabinPhoto').value],
                ordering: 9999,
                state: true,
                action: 'added'
            };
            cabinsData.push(newCabin);

            const cont = document.getElementById('cabinsContainer');
            const newCabinDiv = document.createElement('div');

            const html1 = '<input type="hidden" class="cabinId" value="added'+added_counter+'">';
            let html2 = '';
            if (document.getElementById('editCabinPhoto').value !== '') {
                html2 = `<div class="photo align-items-center d-flex" style="background-image: url('`+document.getElementById('editCabinPhoto').value+`');" id="cabin_photo_added`+added_counter+`"><span class="bg-light px-2">1</span></div>`;
            } else {
                html2 = `<div class="photo align-items-center d-flex" id="cabin_photo_added`+added_counter+`"><span class="mx-auto">Нет фотографии</span></div>`;
            }
            const html3 = `<div class="my-3 text-truncate" id="cabin_title_added`+added_counter+`">`+ document.getElementById('editCabinVendor').value +` - `+ document.getElementById('editCabinTitle').value +`</div>`;
            const html4 = `<button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#cabinModal" onclick="editCabin('added`+added_counter+`')">Изменить</button>`
            const html5 = `<button class="btn btn-danger" onclick="deleteCabin('added`+added_counter+`')">Удалить</button>`
            newCabinDiv.className = 'cabin float-start border p-3 me-3 mb-3';
            newCabinDiv.innerHTML = html1 + html2 + html3 + html4 + html5;

            cont.appendChild(newCabinDiv);
            added_counter++;
            cabinsReorder();
        }
        clearCabinForm();
    }

    function sendForm() {
        document.getElementById('ship_description').value = shipDescriptionEditor.getHtml();
        updateDataFromUI();
        document.getElementById('ship_spec').value = JSON.stringify(jsonData, null, 2);
        document.getElementById('ship_cabins').value = JSON.stringify(cabinsData, null, 2);
        document.getElementById('shipForm').submit();
    }

    window.addPair = addPair;
    window.updateData = updateData;
    window.removePair = removePair;

    window.deleteCabin = deleteCabin;
    window.addCabin = addCabin;
    window.editCabin = editCabin;
    window.saveCabin = saveCabin;
    window.clearCabinForm = clearCabinForm;
    window.sendForm = sendForm;

    var AlignStyle = Quill.import('attributors/style/align');
    Quill.register(AlignStyle, true);
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{'align': null}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
        ['link']
    ];
    Quill.prototype.getHtml = function() {
        return this.container.querySelector('.ql-editor').innerHTML;
    };
    Quill.prototype.setHtml = function(data) {
        this.container.querySelector('.ql-editor').innerHTML = data;
    };
    var shipDescriptionEditor = new Quill('#shipDescription', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });

    generateEditor();
</script>
@endsection

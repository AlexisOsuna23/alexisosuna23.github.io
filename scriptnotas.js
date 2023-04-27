    // Obtener el contenido del bloc de notas desde el almacenamiento local
    var savedContent = localStorage.getItem('notas');

    // Mostrar las notas guardadas en el panel lateral
    if (savedContent) {
        var notesArray = savedContent.split('|');
        for (var i = 0; i < notesArray.length; i++) {
            var noteItem = document.createElement('li');
            noteItem.className = 'note-item';
            noteItem.textContent = notesArray[i];
            notesList.appendChild(noteItem);
        }
    }

    // Función para guardar el contenido del bloc de notas
    function guardarNota() {
        var content = editor.value;
        if (content !== '') {
            var noteItem = document.createElement('li');
            noteItem.className = 'note-item';
            noteItem.textContent = content;
            notesList.appendChild(noteItem);
            editor.value = '';
            editor.focus();

            // Actualizar el contenido del almacenamiento local
            savedContent = localStorage.getItem('notas');
            if (savedContent) {
                savedContent += '|' + content;
            } else {
                savedContent = content;
            }
            localStorage.setItem('notas', savedContent);
        }
    }

    // Evento click en el botón de guardar
    btnGuardar.addEventListener('click', guardarNota);

    // Evento Enter en el textarea para guardar la nota
    editor.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            guardarNota();
        }
    });

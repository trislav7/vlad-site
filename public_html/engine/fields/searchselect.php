<div class="mb-3">
    <!-- Third Dropdown -->
    <label class="form-label">Выберите направление:</label>
    <div class="d-flex gap-2 align-items-start">
        <div class="dropdown tree-dropdown flex-grow-1" id="treeDropdown">
            <button class="form-control w-100 text-start d-flex justify-content-between align-items-center"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <span class="selected-value">Не установлено</span>
                <i class="bi bi-chevron-down"></i>
            </button>
            <div class="dropdown-menu w-100 p-0 custom-dropdown">
                <div class="p-3 border-bottom bg-light sticky-top">
                    <input type="text"
                           class="form-control search-input"
                           placeholder="Поиск..."
                           autocomplete="off">
                </div>
                <div class="tree-list p-2"></div>
                <div class="no-results text-center text-muted p-3 d-none">
                    Ничего не найдено
                </div>
            </div>
        </div>
        <input type="hidden" class="hidden-id-field" id="hiddenField3" name="direction_id" value="0">
    </div>
</div>

<script>
    class TreeDropdown {
        constructor(dropdownElement, customData = null) {
            this.dropdownElement = dropdownElement;
            this.selectedItem = null;
            this.searchQuery = '';
            this.data = customData || this.getDefaultTreeData();
            this.hiddenField = this.findHiddenField();
            this.init();
        }

        findHiddenField() {
            // Ищем hidden поле рядом с dropdown
            const container = this.dropdownElement.parentElement;
            return container.querySelector('.hidden-id-field');
        }

        getDefaultTreeData() {
            return [
                {
                    id: 0,
                    text: 'Не установлено',
                    level: 0,
                    expanded: false,
                    children: []
                },
                {
                    id: 1,
                    text: 'Технологии и IT',
                    level: 0,
                    expanded: false,
                    children: [
                        {
                            id: 2,
                            text: 'Программирование',
                            level: 1,
                            expanded: false,
                            children: [
                                {
                                    id: 3,
                                    text: 'Frontend разработка',
                                    level: 2,
                                    expanded: false,
                                    children: [
                                        { id: 31, text: 'React', level: 3, children: [] },
                                        { id: 32, text: 'Vue.js', level: 3, children: [] },
                                        { id: 33, text: 'Angular', level: 3, children: [] }
                                    ]
                                },
                                {
                                    id: 4,
                                    text: 'Backend разработка',
                                    level: 2,
                                    expanded: false,
                                    children: [
                                        { id: 41, text: 'Node.js', level: 3, children: [] },
                                        { id: 42, text: 'Python Django', level: 3, children: [] },
                                        { id: 43, text: 'Java Spring', level: 3, children: [] }
                                    ]
                                }
                            ]
                        },
                        {
                            id: 5,
                            text: 'Дизайн',
                            level: 1,
                            expanded: false,
                            children: [
                                {
                                    id: 6,
                                    text: 'UI/UX дизайн',
                                    level: 2,
                                    expanded: false,
                                    children: [
                                        { id: 61, text: 'Интерфейсы приложений', level: 3, children: [] },
                                        { id: 62, text: 'Веб-дизайн', level: 3, children: [] }
                                    ]
                                }
                            ]
                        }
                    ]
                },
                {
                    id: 7,
                    text: 'Бизнес',
                    level: 0,
                    expanded: false,
                    children: [
                        {
                            id: 8,
                            text: 'Маркетинг',
                            level: 1,
                            expanded: false,
                            children: [
                                { id: 9, text: 'Digital маркетинг', level: 2, children: [] },
                                { id: 10, text: 'Контент-маркетинг', level: 2, children: [] }
                            ]
                        }
                    ]
                }
            ];
        }

        init() {
            this.renderTree();
            this.setupEventListeners();
            // Инициализируем hidden поле значением по умолчанию
            this.updateHiddenField();
        }

        setupEventListeners() {
            const searchInput = this.dropdownElement.querySelector('.search-input');
            const treeList = this.dropdownElement.querySelector('.tree-list');

            searchInput.addEventListener('input', (e) => {
                this.searchQuery = e.target.value.toLowerCase().trim();
                this.filterTree();
            });

            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const dropdownInstance = bootstrap.Dropdown.getInstance(this.dropdownElement);
                    dropdownInstance.hide();
                }
            });

            treeList.addEventListener('click', (e) => {
                this.handleTreeClick(e);
            });
        }

        filterTree() {
            if (!this.searchQuery) {
                this.collapseAll();
                this.renderTree();
                return;
            }

            this.markMatchingItems(this.data);
            this.renderFilteredTree();
        }

        markMatchingItems(items) {
            let hasVisibleChildren = false;

            for (const item of items) {
                item._visible = false;
                item._hasVisibleChildren = false;

                const matches = item.text.toLowerCase().includes(this.searchQuery);

                if (item.children && item.children.length > 0) {
                    const childHasMatches = this.markMatchingItems(item.children);
                    item._hasVisibleChildren = childHasMatches;
                }

                item._visible = matches || item._hasVisibleChildren;

                if (item._visible) {
                    hasVisibleChildren = true;
                }

                if (item._hasVisibleChildren) {
                    item.expanded = true;
                }
            }

            return hasVisibleChildren;
        }

        renderFilteredTree() {
            const treeList = this.dropdownElement.querySelector('.tree-list');
            const noResults = this.dropdownElement.querySelector('.no-results');

            const visibleItems = this.getVisibleItems(this.data);

            if (visibleItems.length === 0) {
                treeList.innerHTML = '';
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
                treeList.innerHTML = this.renderItems(visibleItems);
            }
        }

        getVisibleItems(items, result = []) {
            for (const item of items) {
                if (item._visible) {
                    result.push(item);
                    if (item.children && item.children.length > 0 && item.expanded) {
                        this.getVisibleItems(item.children, result);
                    }
                }
            }
            return result;
        }

        renderTree() {
            const treeList = this.dropdownElement.querySelector('.tree-list');
            treeList.innerHTML = this.renderItems(this.data);
        }

        renderItems(items) {
            return items.map(item => this.renderItem(item)).join('');
        }

        renderItem(item) {
            const hasChildren = item.children && item.children.length > 0;
            const isSelected = this.selectedItem && this.selectedItem.id === item.id;
            const paddingLeft = (item.level * 24) + 12;

            return `
                    <div class="tree-item ${isSelected ? 'selected' : ''}" 
                         style="padding-left: ${paddingLeft}px">
                        <div class="d-flex align-items-center">
                            ${hasChildren ? `
                                <span class="tree-arrow me-2 ${item.expanded ? 'rotated' : ''}" 
                                      data-item-id="${item.id}">
                                    ▶
                                </span>
                            ` : '<span class="tree-placeholder me-2"></span>'}
                            
                            <span class="tree-item-text flex-grow-1" 
                                  data-item-id="${item.id}">
                                ${this.highlightMatch(item.text)}
                            </span>
                        </div>
                    </div>
                    ${hasChildren && item.expanded ? `
                        <div class="tree-children open">
                            ${this.renderItems(item.children)}
                        </div>
                    ` : ''}
                `;
        }

        highlightMatch(text) {
            if (!this.searchQuery) return text;

            const regex = new RegExp(`(${this.escapeRegex(this.searchQuery)})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        findItemById(id, items = this.data) {
            for (const item of items) {
                if (item.id === id) return item;
                if (item.children && item.children.length > 0) {
                    const found = this.findItemById(id, item.children);
                    if (found) return found;
                }
            }
            return null;
        }

        toggleItem(id) {
            const item = this.findItemById(id);
            if (item) {
                item.expanded = !item.expanded;
                if (this.searchQuery) {
                    this.filterTree();
                } else {
                    this.renderTree();
                }
            }
        }

        selectItem(id) {
            const item = this.findItemById(id);
            if (item) {
                this.selectedItem = item;
                const selectedValueElement = this.dropdownElement.querySelector('.selected-value');
                selectedValueElement.textContent = item.text;

                // Обновляем hidden поле
                this.updateHiddenField();

                // Обновляем глобальное отображение
                this.updateGlobalDisplay();

                // Закрываем dropdown
                const dropdownInstance = bootstrap.Dropdown.getInstance(this.dropdownElement);
                dropdownInstance.hide();
            }
        }

        updateHiddenField() {
            if (this.hiddenField) {
                const value = this.selectedItem ? this.selectedItem.id : 0;
                this.hiddenField.value = value;
                console.log(`Hidden field ${this.hiddenField.id} updated:`, value);
            }
        }

        // updateGlobalDisplay() {
        //     const selectedValuesContainer = document.getElementById('selectedValues');
        //     const dropdowns = document.querySelectorAll('.tree-dropdown');
        //
        //     let html = '';
        //     dropdowns.forEach((dropdown, index) => {
        //         const selectedValueElement = dropdown.querySelector('.selected-value');
        //         const hiddenField = dropdown.parentElement.querySelector('.hidden-id-field');
        //         const label = dropdown.closest('.dropdown-container').querySelector('.form-label').textContent;
        //         const value = selectedValueElement.textContent;
        //         const id = hiddenField ? hiddenField.value : 'N/A';
        //
        //         html += `<div class="mb-2">
        //                 <strong>${label}:</strong>
        //                 <span class="text-primary">${value}</span>
        //                 <small class="text-muted">(ID: ${id})</small>
        //             </div>`;
        //     });
        //
        //     selectedValuesContainer.innerHTML = html;
        // }

        validateSelection() {
            if (this.selectedItem && !this.isItemInList(this.selectedItem)) {
                this.selectedItem = this.data.find(item => item.id === 0);
                const selectedValueElement = this.dropdownElement.querySelector('.selected-value');
                selectedValueElement.textContent = 'Не установлено';
                this.updateHiddenField();
              //  this.updateGlobalDisplay();
            }
        }

        isItemInList(item) {
            return this.findItemById(item.id) !== null;
        }

        collapseAll(items = this.data) {
            for (const item of items) {
                item.expanded = false;
                if (item.children && item.children.length > 0) {
                    this.collapseAll(item.children);
                }
            }
        }

        handleTreeClick(e) {
            const target = e.target;
            const itemId = target.getAttribute('data-item-id');

            if (!itemId) return;

            if (target.classList.contains('tree-arrow')) {
                e.stopPropagation();
                this.toggleItem(parseInt(itemId));
            } else if (target.classList.contains('tree-item-text')) {
                this.selectItem(parseInt(itemId));
            }
        }

        // Public methods
        getSelectedValue() {
            return this.selectedItem ? this.selectedItem.text : 'Не установлено';
        }

        getSelectedItem() {
            return this.selectedItem;
        }

        getSelectedId() {
            return this.selectedItem ? this.selectedItem.id : 0;
        }
    }

    // Initialize multiple dropdowns
    const treeDropdowns = new Map();

    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = new TreeDropdown(document.getElementById('treeDropdown'));
        treeDropdowns.set('treeDropdown', dropdown);

        // Initialize Bootstrap dropdowns
        document.querySelectorAll('.tree-dropdown').forEach(dropdownElement => {
            new bootstrap.Dropdown(dropdownElement);

            dropdownElement.addEventListener('hidden.bs.dropdown', function() {
                const searchInput = this.querySelector('.search-input');
                searchInput.value = '';

                const dropdownInstance = treeDropdowns.get(this.id);
                if (dropdownInstance) {
                    dropdownInstance.searchQuery = '';
                    dropdownInstance.collapseAll();
                    dropdownInstance.renderTree();
                    dropdownInstance.validateSelection();
                }
            });
        });

        // Global click outside handler
        document.addEventListener('click', function(e) {
            treeDropdowns.forEach(dropdown => {
                if (!dropdown.dropdownElement.contains(e.target)) {
                    dropdown.validateSelection();
                }
            });
        });

        // Initial display update
       // dropdown.updateGlobalDisplay();
    });

    // // Utility functions
    // function getAllSelectedValues() {
    //     const results = {};
    //     treeDropdowns.forEach((dropdown, id) => {
    //         results[id] = {
    //             value: dropdown.getSelectedValue(),
    //             id: dropdown.getSelectedId(),
    //             item: dropdown.getSelectedItem()
    //         };
    //     });
    //     return results;
    // }

    // function logFormData() {
    //     const formData = new FormData();
    //     const hiddenFields = document.querySelectorAll('.hidden-id-field');
    //
    //     hiddenFields.forEach(field => {
    //         formData.append(field.name, field.value);
    //     });
    //
    //     console.log('Form data:');
    //     for (let [name, value] of formData.entries()) {
    //         console.log(`${name}: ${value}`);
    //     }
    //
    //     const selectedValues = getAllSelectedValues();
    //     console.log('Selected values:', selectedValues);
    // }

    function submitForm() {
        const formData = new FormData();
        const hiddenFields = document.querySelectorAll('.hidden-id-field');

        hiddenFields.forEach(field => {
            formData.append(field.name, field.value);
        });

        // Здесь можно отправить данные на сервер
        // alert('Данные формы готовы к отправке! Проверьте консоль для просмотра данных.');
        // logFormData();

        // Пример отправки fetch запросом
        /*
        fetch('/submit', {
            method: 'POST',
            body: formData
        }).then(response => {
            // Обработка ответа
        });
        */
    }

    // function logSelectedValues() {
    //     const selected = getAllSelectedValues();
    //     console.log('Selected values:', selected);
    // }
</script>

document.addEventListener("DOMContentLoaded", function () {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var jsonData = JSON.parse(this.responseText);
            displayCategoriesButton(jsonData.books);
        }
    };
    xhr.open("GET", "book.json", true);
    xhr.send();
});

function displayCategoriesButton(books) {
    var categoriesButton = document.getElementById("categoriesButton");
    categoriesButton.addEventListener("click", function () {
        displayTable('bookTable', books);
        toggleTableVisibility('bookTable');
    });

    addXmlButtonListener("xmlButton1", "perfume.xml", 'xmlTable1');
    addXmlButtonListener("xmlButton2", "electronic1.xml", 'xmlTable2');
    addXmlButtonListener("xmlButton3", "electronic2.xml", 'xmlTable3');
}

function addXmlButtonListener(buttonId, xmlFileName, tableId) {
    var xmlButton = document.getElementById(buttonId);
    xmlButton.addEventListener("click", function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var xmlData = parseXml(this.responseXML);
                displayTable(tableId, xmlData);
                toggleTableVisibility(tableId);
            }
        };
        xhr.open("GET", xmlFileName, true);
        xhr.send();
    });
}

function parseXml(xml) {
    var result = [];
    var items = xml.getElementsByTagName("perfume");
    if (items.length === 0) {
        items = xml.getElementsByTagName("product");
    }

    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        var rowData = {};

        for (var j = 0; j < item.children.length; j++) {
            var child = item.children[j];
            rowData[child.tagName] = child.textContent;
        }

        result.push(rowData);
    }

    return result;
}

function displayTable(tableId, data) {
    var table = document.getElementById(tableId);
    table.innerHTML = ""; 
    if (data.length === 0) {
        table.style.display = "none"; 
        return;
    }

    var headers = Object.keys(data[0]);
    var headerRow = table.insertRow(0);
    for (var i = 0; i < headers.length; i++) {
        var headerCell = headerRow.insertCell(i);
        headerCell.innerHTML = headers[i];
    }

    for (var i = 0; i < data.length; i++) {
        var row = table.insertRow(i + 1);
        for (var j = 0; j < headers.length; j++) {
            var cell = row.insertCell(j);

            if (headers[j] === "img") {
                var img = document.createElement("img");
                img.src = data[i][headers[j]];
                cell.appendChild(img);
            } else {
                cell.innerHTML = data[i][headers[j]];
            }
        }
    }

    table.style.display = "table"; 
}

function toggleTableVisibility(tableId) {
    var allTables = document.querySelectorAll('.dataTable');
    for (var i = 0; i < allTables.length; i++) {
        allTables[i].style.display = (allTables[i].id === tableId) ? 'table' : 'none';
    }
}


function searchProducts(searchType) {
    var searchForm = (searchType === 'keyword') ? document.getElementById("keywordSearchForm") : document.getElementById("priceSearchForm");
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var searchData = JSON.parse(this.responseText);
            displayTable('searchResultsTable', searchData);
            toggleTableVisibility('searchResultsTable');
        }
    };

    var formData = new FormData(searchForm);
    xhr.open("POST", "search.php", true);
    xhr.send(formData);
}

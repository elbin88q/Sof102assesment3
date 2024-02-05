function searchProducts() {
    var keyword = document.getElementById("keyword").value;
    var minPrice = document.getElementById("minPrice").value;
    var maxPrice = document.getElementById("maxPrice").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var searchData = JSON.parse(this.responseText);
            displaySearchResults(searchData);
        }
    };
    xhr.open("GET", "search1.php?keyword=" + keyword + "&minPrice=" + minPrice + "&maxPrice=" + maxPrice, true);
    xhr.send();
}

function displaySearchResults(searchData) {
    var resultTable = document.getElementById("resultTable");
    resultTable.innerHTML = ""; 

    if (searchData.length === 0) {
        resultTable.innerHTML = "<p>No results found.</p>";
        return;
    }

    var heading = document.createElement('h3');
    heading.textContent = 'Search Results for Books';
    resultTable.appendChild(heading);

    var table = document.createElement("table");
    table.border = "1";
    table.style.width = "100%";

    var headers = Object.keys(searchData[0]);
    var headerRow = table.insertRow(0);
    for (var i = 0; i < headers.length; i++) {
        var headerCell = headerRow.insertCell(i);
        headerCell.innerHTML = headers[i];
    }

    for (var i = 0; i < searchData.length; i++) {
        var row = table.insertRow(i + 1);
        for (var j = 0; j < headers.length; j++) {
            var cell = row.insertCell(j);

            if (headers[j] === "img") {
                var img = document.createElement("img");
                img.src = searchData[i][headers[j]];
                img.style.maxWidth = "100px"; 
                cell.appendChild(img);
            } else {
                cell.innerHTML = searchData[i][headers[j]];
            }
        }
    }

    resultTable.appendChild(table);
}

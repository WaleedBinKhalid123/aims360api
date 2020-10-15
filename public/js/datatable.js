

/**
 *
 * @returns {{serverSide: boolean, processing: boolean}}
 */
const dataTableSettings = function () {
    return {
        serverSide: true,
        processing: true,
    };
};

/**
 *
 * @param selector
 * @param url
 * @param column
 * @param columnDef
 * @param target
 */
const dataTables = function (selector, url, column = null, columnDef = null, target = null) {
    let columns = column === null ? setBySelector(selector) : pushColumns(column);
    let settings = dataTableSettings();
    $(selector).DataTable({
        serverSide: settings.serverSide,
        processing: settings.processing,
        "ajax": {
            "header": {
                'X-Requested-With': "XMLHttpRequest"
            },
            "url": url
        },
        "columns": columns,
        columnDefs: columnDef
    });
};

/**
 *
 * @param column
 * @returns {[]}
 */
const pushColumns = function (column) {
    let columns = [];
    column.forEach(col => {
        columns.push({data: col});
    });
    return columns;
};

/**
 *
 * @param selector
 @returns {[]}
 */
const setBySelector = function (selector) {
    let columns = [];
    $(selector).find('th').each((i, a) => {
        if ($(a).text() !== 'action') {
            columns.push($(a).text().replace(/\s+/g, '_').toLowerCase());
        }
    });
    return pushColumns(columns);
};
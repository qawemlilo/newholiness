
var fs = require('fs'),
    path = require('path'),
    members = fs.readFileSync('../dbs/tgqq_pastors.json', 'utf8'),
    sql = "INSERT INTO `#__hpmembers`(`id`, `userid`, `imgext`, `church`) VALUES ";

members = JSON.parse(members);

members.forEach(function (member) {
    var query = createInsertQuery(member); 
    
    sql += query + ',\n'; 
});


function createInsertQuery(obj) {
    var query = '(';
    
    query += obj.id + ", ";
    query += obj.userid + ", ";
    query += "'" + path.extname(obj.url).substring(1)  + "', ";
    query += "'" + obj.church.replace(/'/g, "\\'")  + "')";
    
    return query;
}

fs.writeFileSync('../members.sql', sql);
console.log('Done!');

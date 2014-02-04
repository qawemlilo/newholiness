
var fs = require('fs'),
    path = require('path'),
    partners = require('../dbs/tgqq_partners.json'),
    sql = 'INSERT INTO `usl1i_devotion_partners`(`userid`, `partnerid`, `active`, `ts`) VALUES ';


partners.forEach(function (partnership) {
    var query = createInsertQuery(partnership), 
        user = query.user, 
        friend = query.friend; 
    
        sql += user + ',\n';
        sql += friend + ',\n';        
});


function createInsertQuery(obj) {
    var query = '(', query2 = '(', result = {};

    query += obj.firstpartner + ", ";
    query += obj.secondpartner + ", ";
    query += obj.active + ", ";
    query += "'" + obj.ts  + "')";
    
    query2 += obj.secondpartner + ", ";
    query2 += obj.firstpartner + ", ";
    query2 += obj.active + ", ";
    query2 += "'" + obj.ts  + "')";
    
    result.user = query;
    result.friend = query2;
    
    return result;
}

fs.writeFileSync('../com_holiness/admin/sql/partners.sql', sql);
console.log('Done!');
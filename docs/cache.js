
var fs = require('fs');

var partners = require('./cleanpartners.json');

var str = "INSERT INTO `usl1i_devotion_partners` (`id`, `userid`, `partnerid`, `active`, `ts`) VALUES \n";

partners.forEach(function (partner) {
   str += "(" + partner.id + "," + partner.userid + "," + partner.partnerid + "," + partner.active + "," + partner.ts + "),\n";
});

fs.writeFileSync('partners.sql', str);
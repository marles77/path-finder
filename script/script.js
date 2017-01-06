/*encoding="UTF-8;*/

//alert('Script loaded');

//ustawiamy właściwość TOP dla result map
var nodeNum = (parseInt(map_num)-1);
var nodes = document.getElementById('pack').getElementsByTagName('section');
var nodeSection = nodes[nodeNum];
var nodeTop = nodes[nodeNum].offsetTop;
document.getElementById('result_map').style.top = nodeTop + 'px';


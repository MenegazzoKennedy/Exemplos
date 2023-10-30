const fs = require('fs');
const jsonData = fs.readFileSync('./drive.json', 'utf-8');
var text = JSON.parse(jsonData);
var insert = "INSERT INTO wp_drive_arquives (id_folder, name, path, type) VALUES ";
var i = 0
text.rows.forEach(row => {
   JSON.parse(row.date_salvar).forEach(arquivo => {
        var name = arquivo.name.replace('"', "'");
        // if(i < 10){
            if(insert == "INSERT INTO wp_drive_arquives (id_folder, name, path, type) VALUES "){
                insert += "("+row.post_ID+", '"+name+"', '"+arquivo.file+"', '"+arquivo.type+"')";
            }else{
                insert += ", ("+row.post_ID+", '"+name+"', '"+arquivo.file+"', '"+arquivo.type+"')";
            }
        // }
        i++;
    });
});
const nomeArquivo = 'sqldrivenovo.txt';
const caminhoArquivo = './' + nomeArquivo;

fs.writeFile(caminhoArquivo, insert, function (err) {
  if (err) throw err;
  console.log('Arquivo criado com sucesso!');
});
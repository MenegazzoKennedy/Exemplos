

const xlsx = require('xlsx');
const fs = require('fs');

const axios = require('axios');

// const download_image = (url, image_path) =>
//   axios({
//     url,
//     responseType: 'stream',
//   }).then(
//     response =>
//       new Promise((resolve, reject) => {
//         var caminho = image_path.split("/");
//         var caminhoCorreto = "";
//         var index = 0;
//         while(index < caminho.length - 1){
//             if(caminhoCorreto == ""){
//                 caminhoCorreto = caminho[index];
//             }else{
//                 caminhoCorreto = caminhoCorreto+"/"+caminho[index];
//             }
//             index++;
//             if (!fs.existsSync(caminhoCorreto)){
//                 //Efetua a criação do diretório
//                 fs.mkdirSync(caminhoCorreto);
//             }
//         }
//         response.data
//           .pipe(fs.createWriteStream(image_path))
//           .on('finish', () => resolve())
//           .on('error', e => reject(e));
//       }),
//   );



// (async () => {
//   try {
//     var indice = 12;
//     const response = await axios.get("http://dev.maiscode.com.br:2222/biofaces/apiposts/"+indice);
//     var posts = response.data.timeline;
//     if(posts.length != 0){
//         for (post in posts ) {
//             var url = "https://biofaces.com/img/"+posts[post].id_usuario+"/c/280/210/post/"+posts[post].arquivo;
//             await download_image(url, posts[post].arquivo)
//         }
//         console.log("terminou");
//     }else{
//         console.log("acabaram as imagens");
//     }
// } catch (error) {
//     console.log(error);
// }
// })();
const workbook = xlsx.readFile('./imagens_galeria_insert.xlsx');
const worksheet = workbook.Sheets[workbook.SheetNames[0]];
var insert = "INSERT INTO `wp_posts`(post_title, post_content, post_excerpt, to_ping, pinged, post_content_filtered, post_date, post_modified_gmt) VALUES ";
$teste = 0;
xlsx.utils.sheet_to_json(worksheet).forEach(row => {
  $teste++;
  // try {
    // if($teste > 2499){
      var img = "";
      if(typeof row.imagem !== "undefined" && row.imagem.length > 0 && row.imagem != "" && row.imagem != '\\N'  && row.imagem != '\N'){
        img = row.imagem.split("/");
        img = img[img.length - 1];
        img = "https://satage.maiscode.com.br/crf/wp-content/uploads/2023/04/"+img;
        img = img.replace("'", '"').replace("`", "");
      }
      var titulo = "";
      if(typeof row.titulo !== "undefined" && row.titulo.length > 0 && row.titulo != "" && row.titulo != '\\N'  && row.titulo != '\N'){
        titulo = row.titulo;
        titulo = titulo.replace("'", '"').replace("`", "");
      }
      var texto = "";
      if(typeof row.texto !== "undefined" && row.texto.length > 0 && row.texto != "" && row.texto != '\\N'  && row.texto != '\N'){
        textoArray = row.texto.split("<br />");
        if(typeof row.subtitulo !== "undefined" && row.subtitulo.length > 0 && row.subtitulo != "" && row.subtitulo != '\\N'  && row.subtitulo != '\N'){
          texto += "<!-- wp:paragraph --><h2>"+row.subtitulo+"</h2>";
        }
        textoArray.forEach(function(paragrafo){
          texto += "<!-- /wp:paragraph --><!-- wp:paragraph -->"+paragrafo;
        });
        if(texto != ""){
          texto += "<!-- /wp:paragraph -->";
          texto = texto.replace("'", '"').replace("`", " ");
        }
      }
      var resumo = "";
      if(typeof row.resumo !== "undefined" && row.resumo.length > 0 && row.resumo != "" && row.resumo != '\\N'  && row.resumo != '\N'){
        var resumo = row.resumo.replace("'", '"');
      }
      var data = "00-00-0000 00:00:00";
      texto = texto.replace("'", '"').replace("`", " ").replace("´", " ");
      resumo = resumo.replace("'", '"').replace("`", " ").replace("´", " ");
      titulo = titulo.replace("'", '"').replace("`", " ").replace("´", " ");
      data = data.replace("'", '"').replace("`", " ");
      if(typeof row.data !== "undefined" && row.data.length > 0 && row.data != "" && row.data != '\\N'  && row.data != '\N'){
        data = row.data.replace("'", '"').replace("`", "");
      }
      if(insert == "INSERT INTO `wp_posts`(post_title, post_content, post_excerpt, to_ping, pinged, post_content_filtered, post_date, post_modified_gmt) VALUES "){
        insert += "('"+titulo+"', '"+texto+"', '"+resumo+"', 'mc_noticias', '', '', '"+data+"', NOW())";
      }else{
        insert += ", ('"+titulo+"', '"+texto+"', '"+resumo+"', 'mc_noticias', '', '', '"+data+"', NOW())";
      }

  // }catch (error) {
  //   console.log(error);
  // }
  // }
});
console.log($teste);
const nomeArquivo = 'sqlnovo.txt';
const caminhoArquivo = './' + nomeArquivo;

fs.writeFile(caminhoArquivo, insert, function (err) {
  if (err) throw err;
  console.log('Arquivo criado com sucesso!');
});
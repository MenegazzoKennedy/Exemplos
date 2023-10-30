const xlsx = require('xlsx');
const fs = require('fs');

const axios = require('axios');

const download_image = (url, image_path) =>
  axios({
    url,
    responseType: 'stream',
  }).then(
    response =>
      new Promise((resolve, reject) => {
        var caminho = image_path.split("/");
        var caminhoCorreto = "";
        var index = 0;
        while(index < caminho.length - 1){
            if(caminhoCorreto == ""){
                caminhoCorreto = caminho[index];
            }else{
                caminhoCorreto = caminhoCorreto+"/"+caminho[index];
            }
            index++;
            if (!fs.existsSync(caminhoCorreto)){
                //Efetua a criação do diretório
                fs.mkdirSync(caminhoCorreto);
            }
        }
        response.data
          .pipe(fs.createWriteStream(image_path))
          .on('finish', () => resolve())
          .on('error', e => reject(e));
      }),
  );

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
const workbook = xlsx.readFile('./imagens_galeria.xlsx');
const worksheet = workbook.Sheets[workbook.SheetNames[0]];
// quantidade = 5;
// arquivo = xlsx.utils.sheet_to_json(worksheet);
// for(i = ((quantidade - 1)) * 100; i < (quantidade  * 100); i++){
//   try {
//     if(typeof arquivo[i].imagem !== "undefined" && arquivo[i].imagem.length > 0 && arquivo[i].imagem != "" && arquivo[i].imagem != "\\N" && arquivo[i].imagem != "\N"){
//       (async () => {
//         console.log(arquivo[i].imagem+"/1024/724/16:9")
//         await download_image(arquivo[i].imagem+"/1024/724/16:9", arquivo[i].imagem.split("https://www.crfms.org.br/")[1]);
//       })();
//     }else{
//       console.log(arquivo[i].imagem)
//     }
//   }catch (error) {
//     console.log(error);
//   }
// }
arquivo = xlsx.utils.sheet_to_json(worksheet);
var pasta = process.argv[2];
quantidade = arquivo.length;
arquivo.forEach(function(row, key){
  if(key < quantidade - 1 && row.pasta.split("-")[0] == pasta){
    try {
      if(typeof row.imagem !== "undefined" && row.imagem.length > 0 && row.imagem != "" && row.imagem != "\\N"){
        (async () => {
          await download_image(row.imagem.replace("***-***", "-"), "galeria/"+row.pasta+"/"+row.imagem.split("https://www.crfms.org.br/galeria")[1].split("***-***")[0]);
        })();
      }else{
        console.log(row.imagem)
      }
    }catch (error) {
      console.log(error);
    }
  }
});
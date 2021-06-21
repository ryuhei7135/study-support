'use strict';
{

    const deletes = document.querySelectorAll('.delete'); /* バツボタン */
    const folders = document.querySelectorAll('i'); /* フォルダ */
    const lists = document.querySelectorAll('.lists'); /* 一覧画面に表示されているリスト */
    const makeFolderButton = document.querySelector('#makeFolderButton');
    const icon = document.querySelector('[name="icon"]'); //<i class='fas fa-folder fa-3x'></i>
    const token = document.querySelector('[name="token"]');
    const folderDelete = document.querySelectorAll('.folderDelete');

    deletes.forEach((span)=>{
        span.addEventListener('click',()=>{
            if(confirm('本当に削除しますか？')){
                span.parentNode.submit();
            }
        });
    });

    /* フォルダをクリックするとフォルダIDを送信 */
    folders.forEach(folder => {  
        folder.addEventListener('click',()=>{
            folder.parentNode.submit();
        });
    });
    
      /* フォルダをクリックすると一覧画面へ遷移 */
    if(typeof folderId !== 'undefined'){ 
        window.location.href = 'http://localhost:8562/list.php';
    }else{
        ;
    }

    lists.forEach(list =>{
        list.addEventListener('click',()=>{
            list.parentNode.submit();
        });
    });

    if(typeof allRecord !== 'undefined'){ 
        window.location.href = 'http://localhost:8562/record.php';
    }else{
        console.log('表示する記録がセットされていません');
    }

    /* フォルダ作成 */
    /* 非同期でフォルダを作ることに成功したが、リロードしないと表示されないのでDOM操作で予めフォルダを作っておく処理が必要 */
    // makeFolderButton.addEventListener('click',()=>{
    //     fetch('?action=makeFolder',{
    //         method:'POST',
    //         body: new URLSearchParams({
    //             icon: icon.value,
    //             token: token.value
    //         })
    //     })
    //     /* フォルダは作られるがリロードしないと表示されないので前もって作っておく */
    //     const i = document.createElement('i');
    //     i.classList.add("fas","fa-folder","fa-3x");
    //     document.querySelector('.doing-top').appendChild(i);
    // });

    folderDelete.forEach((fdel)=>{
        fdel.addEventListener('click',()=>{
            if(confirm('本当に削除しますか？')){
                fdel.parentNode.submit();
            }
        });
    });

    



    $(function(){

        $('#makeFolderButton').click(function (){
            $('#modal').fadeIn();
        });

        
        history.pushState(null, null, null); //ブラウザバック無効化
        
        //ブラウザバックボタン押下時
        $(window).on("popstate", function (event) {
            history.pushState(null, null, null);
            window.alert('ブラウザの戻るボタンは使わないでください');
        });
           

        
     });






}
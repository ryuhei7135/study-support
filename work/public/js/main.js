'use strict';
{

    const deletes = document.querySelectorAll('.delete'); /* バツボタン */
    const folders = document.querySelectorAll('i'); /* フォルダ */
    const lists = document.querySelectorAll('.lists'); /* 一覧画面に表示されているリスト */
    
    deletes.forEach((span)=>{
        span.addEventListener('click',()=>{
            if(confirm('本当に削除しますか？')){
                span.parentNode.submit();
            }
        });
    });

    /* フォルダをクリックするとフォルダナンバーを送信 */
    folders.forEach(folder => {  
        folder.addEventListener('click',()=>{
            folder.parentNode.submit();
        });
    });
    
      /* フォルダをクリックすると一覧画面へ遷移 */
    if(typeof folderNo !== 'undefined'){ 
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


}

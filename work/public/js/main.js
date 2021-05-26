'use strict';
{

    const deletes = document.querySelectorAll('.delete'); /* バツボタン */

    deletes.forEach((span)=>{
        span.addEventListener('click',()=>{
            if(confirm('本当に削除しますか？')){
                span.parentNode.submit();
            }
        });
    });


    const folders = document.querySelectorAll('i'); /* フォルダ */

    /* アイコンをクリックするとフォルダナンバーを送信 */
    folders.forEach(folder => {  
        folder.addEventListener('click',()=>{
            folder.parentNode.submit();
            
            
            
        });
        
    });
    
      /* アイコンをクリックすると一覧画面へ遷移 */
    if(typeof folderNo !== 'undefined'){ 
        window.location.href = 'http://localhost:8562/list.php';
    }else{
        ;
    }




}
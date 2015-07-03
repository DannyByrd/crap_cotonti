
1. C начала категории потом посты или все в одном файле, но соблюдать ту же очередность:

        <import:categoryitem>
           <import:categorytitle><CD_GRAN_1!></import:categorytitle>
            <import:categoryname><CD_GRAN_2!></import:categoryname>
        </import:categoryitem>

        <import:postitem>
           <import:category><CD_GRAN_4!></import:category>
           <import:title><CD_GRAN_1!></import:title>
           <import:text><CD_GRAN_2!></import:text>
           <import:image><NIMG><CD_GRAN_3!></NIMG></import:image>
        </import:postitem>



2. Разделители:
    
    -  "|" - перечисление категорий
        
            <import:categoryitem>
               <import:categorytitle>Общество|Политика</import:categorytitle>
                <import:categoryname>obschectvo|politika</import:categoryname>
            </import:categoryitem>


    -  ">" - вложенность категорий
    
            <import:categoryitem>
               <import:categorytitle>События>Политика</import:categorytitle>
                <import:categoryname>sobitiya|politika</import:categoryname>
            </import:categoryitem>

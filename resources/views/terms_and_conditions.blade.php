@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('content')

    <!--breadcumb start here-->
    <div class="xs-breadcumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"> Home</a></li>
                    <li class="breadcrumb-item"><a href="/terms-and-conditions">Terms and Conditions</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcumb end here--><!-- End welcome section -->


    <!-- terms and condition section -->
    <div class="xs-section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="terms-list-group">
                        <div class="terms-list media">
                            <i class="fa fa-play d-flex"></i>
                            <div class="media-body">
                                <b>1.1 Spedizioni e Resi</b>
                                <p><b>Costi e modalità di spedizione</b></p>
                                <p>Il costo di spedizione ha come tariffa minima 13,00€ + IVA per le spedizioni nazionali (+ eventuali tasse doganali o costi di transito ove presenti) per tutti gli ordini. Per le spedizioni verso l’estero il costo può variare.</p>
                                <p><b>Pagamento</b></p>
                                <p>II pagamento della merce può avvenire:</p>
                                <ul>
                                    <li>via Stripe;</li>
                                    <li>con carta di credito (Visa, MasterCard, American Express);</li>
                                    <li>con bonifico bancario:<br>
                                        RIFERIMENTI BANCARI:<br>
                                        Banca intesa San paolo IBAN&nbsp; IT 80 Y030 6905 0601 0000 0012 977</li>
                                </ul>
                                <p><b>Termine di Consegna</b></p>
                                <p>Il termine di consegna è di massimo 20 giorni di calendario dalla sottoscrizione dell’ordine, salvo diversa segnalazione esplicitata sul preventivo. Nel caso di richiesta di bozze di stampa, tale termine decorre dalla data di restituzione delle bozze approvate. Non si accettano consegne tassative se non espressamente concordate con il Customer Service.</p>
                                <p>Senza istruzioni contrarie è data facoltà alla Auro.ra promotion S.R.L. di effettuare consegne parziali, fermo restando un solo addebito per le spese di trasporto. AURO.RA PROMOTION S.R.L. è sollevata nei confronti dell’acquirente nei casi di mancata o ritardata consegna anche parziale, dovuti a cause di forza maggiore o a caso fortuito.</p>
                                <p><b>Costo stampa e contributo impianti</b></p>
                                <p>II costo della stampa ed i lotti minimi sono indicati nella descrizione di ciascun articolo. Il costo di stampa indicato si intende sempre ad un solo colore, per stampa a più colori il costo aumenta.</p>
                                <p><b>DIRITTO DI RECESSO</b></p>
                                <p>L’utente ha il diritto di recedere dal contratto, senza indicarne le ragioni, entro 14 giorni e nel solo caso di acquisto di prodotti neutri. Gli articoli personalizzati non possono essere restituiti, se non nel caso di merce rovinata. Il periodo di recesso scade dopo 14 giorni dal giorno di ricezione della merce nel caso di un contratto di vendita:&nbsp;<i>in cui l’utente o un terzo, diverso dal vettore e da Lei designato, acquisisce il possesso fisico dei beni.</i>(DECRETO LEGISLATIVO 21 febbraio 2014, n. 21; attuazione della direttiva 2011/83/UE sui diritti dei consumatori, recante modifica delle direttive 93/13/CEE e 1999/44/CE e che abroga le direttive 85/577/CEE e 97/7/CE).</p>
                                <p>Per esercitare il diritto di recesso, l’utente è tenuto a informarci della sua decisione di recedere dal presente contratto tramite una dichiarazione esplicita, telefonicamente o via email: +39 06 44230326 (dalle 9.00 alle 13.00 e dalle 14.00 alle 18.00 dal lunedì al venerdì, festivi esclusi)<br>
                                    info@aurorapromotion.it</p>
                                <p>Per rispettare il termine di recesso, è sufficiente che il cliente invii la comunicazione relativa all’esercizio del diritto di recesso prima della scadenza del periodo di recesso.</p>
                                <p><b>Effetti del recesso</b></p>
                                <p>La merce personalizzata può essere resa solo per motivi di non conformità, mentre per gli articoli non personalizzati il reso è possibile entro 14 giorni dal ricevimento della merce.</p>
                                <p>Se l’utente recede dal presente contratto, gli saranno rimborsati tutti i pagamenti che ha effettuato a nostro favore, compresi i costi di consegna (ad eccezione dei costi supplementari derivanti dall’eventuale scelta di un tipo di consegna diverso dal tipo meno costoso di consegna standard da noi offerto), senza indebito ritardo e in ogni caso non oltre 14 giorni dal giorno in cui siamo informati della sua decisione di recedere dal presente contratto. Detti rimborsi saranno effettuati utilizzando lo stesso mezzo di pagamento usato per la transazione iniziale, salvo che non si abbia espressamente convenuto altrimenti; in ogni caso, non dovrà sostenere alcun costo quale conseguenza di tale rimborso.</p>
                                <p>L’utente è pregato di rispedire i beni o di consegnarli a noi senza indebiti ritardi, compilando e allegando il modulo di reso e consegnando la merce al fornito, entro 14 giorni dal giorno in cui ci ha comunicato il suo recesso dal presente contratto. Il termine è rispettato se l’utente rispedisce i beni prima della scadenza del periodo di 14 giorni.</p>
                                <p><b>Eccezioni al Diritto di Recesso</b></p>
                                <p>Il diritto di recesso di cui agli articoli da 52 a 58 del Codice Civile per i contratti a distanza e i contratti negoziati fuori dei locali commerciali è escluso relativamente a:</p>
                                <ul>
                                    <li>i contratti di servizi dopo la completa prestazione del servizio se l’esecuzione è iniziata con l’accordo espresso del consumatore e con l’accettazione della perdita del diritto di recesso a seguito della piena esecuzione del contratto da parte del professionista;</li>
                                    <li>la fornitura di beni o servizi il cui prezzo è legato a fluttuazioni nel mercato finanziario che il professionista non è in grado di controllare e che possono verificarsi durante il periodo di recesso;</li>
                                    <li>la fornitura di beni confezionati su misura o chiaramente personalizzati;</li>
                                    <li>la fornitura di beni che rischiano di deteriorarsi o scadere rapidamente;</li>
                                    <li>la fornitura di beni sigillati che non si prestano ad essere restituiti per motivi igienici o connessi alla protezione della salute e sono stati aperti dopo la consegna;</li>
                                    <li>la fornitura di beni che, dopo la consegna, risultano, per loro natura, inscindibilmente mescolati con altri beni;</li>
                                    <li>la fornitura di bevande alcoliche, il cui prezzo sia stato concordato al momento della conclusione del contratto di vendita, la cui consegna possa avvenire solo dopo trenta giorni e il cui valore effettivo dipenda da fluttuazioni sul mercato che non possono essere controllate dal professionista;</li>
                                    <li>i contratti in cui il consumatore ha specificamente richiesto una visita da parte del professionista ai fini dell’effettuazione di lavori urgenti di riparazione o manutenzione. Se, in occasione di tale visita, il professionista fornisce servizi oltre a quelli specificamente richiesti dal consumatore o beni diversi dai pezzi di ricambio necessari per effettuare la manutenzione o le riparazioni, il diritto di recesso si applica a tali servizi o beni supplementari;</li>
                                    <li>la fornitura di registrazioni audio o video sigillate o di software informatici sigillati che sono stati aperti dopo la consegna;</li>
                                    <li>la fornitura di giornali, periodici e riviste ad eccezione dei contratti di abbona-mento per la fornitura di tali pubblicazioni;</li>
                                    <li>i contratti conclusi in occasione di un’asta pubblica;</li>
                                    <li>la fornitura di alloggi per fini non residenziali, il trasporto di beni, i servizi di noleggio di autovetture, i servizi di catering o i servizi riguardanti le attività del tempo libero qualora il contratto preveda una data o un periodo di esecuzione specifici;</li>
                                    <li>la fornitura di contenuto digitale mediante un supporto non materiale se l’esecuzione è iniziata con l’accordo espresso del consumatore e con la sua accettazione del fatto che in tal caso avrebbe perso il diritto di recesso.</li>
                                </ul>
                            </div>
                        </div><!-- .terms-list END -->
                        <div class="terms-list media">
                            <i class="fa fa-play d-flex"></i>
                            <div class="media-body">
                                <b>1.2 Condizioni Generali di Vendita</b>
                                <p>Le presenti condizioni generali di vendita si applicano all’acquisto dei prodotti sul sito e-commerce aurorapromotion.it. I prodotti acquistati su aurorapromotion.it sono venduti direttamente da Auro.ra Promotion S.R.L. Via degli scipioni, 235 00192, Roma, Italia.</p>
                                <p>P. Iva: 14212501002. L’utente potrà richiedere qualsiasi informazione AURO.RA PROMOTION S.R.L. scrivendo una mail a&nbsp;<a href="mailto:info@gadgetaziendali.it">info@aurorapromotion.it</a>&nbsp;o telefonando al numero: +39 06 44230326</p>
                                <p><b>Servizi offerti dal sito</b></p>
                                <p>Il Sito permette di usufruire di servizi di web to print (i “Servizi”).</p>
                                <p>Quando parliamo di “consumatore” ci riferiamo a qualsiasi persona fisica che agisce su aurorapromotion.it con finalità non riferibili alla propria attività commerciale, imprenditoriale o professionale, eventualmente svolta. Se non sei un “consumatore”, ti invitiamo ad astenerti dal concludere transazioni commerciali attraverso aurorapromotion.it.</p>
                                <p>Per accedere ai Servizi è necessario registrarsi al Sito. In fase di registrazione verrà chiesto agli utenti di specificare se intendono registrarsi e quindi effettuare gli acquisti in qualità di società, ditta individuale/libero professionista, privato o associazione, specificando altresì la nazionalità dell’utente. Solamente gli acquisti effettuati da utenti privati saranno soggetti alla disciplina applicabile in materia di consumatori.</p>
                                <p>Tutti i prezzi finali dei prodotti visualizzati sul Sito sono espressi in euro, IVA esclusa. I prezzi dei prodotti possono essere soggetti a variazioni periodiche.</p>
                                <p>Per determinati prodotti e offerte le spese di spedizioni sono da considerarsi incluse. Per tutti i rimanenti prodotti queste ultime sono a carico dell’utente.</p>
                                <p><b>Garanzie ed indicazione dei prezzi dei prodotti</b></p>
                                <p>Su aurorapromotion.it sono offerti in vendita esclusivamente prodotti di prima qualità, personalizzabili tramite numerose tecniche di stampa. Il Venditore non vende prodotti usati, irregolari o di qualità inferiore ai corrispondenti standard offerti sul mercato.</p>
                                <p>Le immagini ed i colori dei prodotti offerti in vendita su aurorapromotion.it potrebbero non essere corrispondenti a quelli reali per effetto del browser Internet e del monitor utilizzato. Il Venditore si impegna ad offrire il miglior servizio di stampa e personalizzazione possibile. Tuttavia, i colori e il risultato finale potrebbero non corrispondere in modo esatto all’anteprima generata online.</p>
                                <p>I prezzi dei prodotti potrebbero essere soggetti ad aggiornamenti. L’utente è tenuto ad accertarsi del prezzo finale di vendita prima di inoltrare il relativo modulo d’ordine. I prezzi, i prodotti in vendita sul sito e/o le caratteristiche degli stessi, sono soggetti a variazioni senza preavviso. Prima di inviare l’ordine, il Consumatore è invitato a verificare il prezzo finale di vendita.</p>
                                <p>Il prezzo dei Prodotti è quello indicato sul Sito contestualmente all’invio dell’ordine da parte del Consumatore. I prezzi sono comprensivi dei costi di imballaggio standard al netto dell’IVA e di eventuali imposte indirette (qualora applicabili), mentre non comprendono le spese di spedizione che sono calcolati prima della conferma dell’ordine trasmessa dal Venditore al Consumatore e che lo stesso Consumatore si impegna a versare al Venditore in aggiunta al prezzo indicato sul Sito.</p>
                                <p>Qualora i prodotti, presentati su aurorapromotion.it, non siano più disponibili o in vendita al momento del tuo ultimo accesso al sito ovvero dell’invio del modulo d’ordine, sarà cura del Venditore comunicarti, tempestivamente ed in ogni caso entro 7 giorni a decorrere dal giorno successivo a quello in cui avrai trasmesso il tuo ordine al Venditore, l’eventuale indisponibilità dei prodotti ordinati. In caso di inoltro del modulo d’ordine e pagamento del prezzo, il Venditore provvederà a rimborsare quanto da te già anticipato.</p>
                                <p><b>Scelta del prodotto e modalità d’acquisto</b></p>
                                <p>Dopo essersi autenticato, l’utente potrà procedere alla selezione dei prodotti così come descritti nelle relative sezioni, selezionandoli volta per volta, personalizzandoli, e aggiungendo le quantità desiderate nel proprio carrello degli acquisti. Alcune immagini possono essere fornite a scopo informativo e potrebbero differire dall’aspetto del prodotto consegnato.</p>
                                <p>In prima fase, l’utente che naviga e simula sull’e-commerce un ordine ha a disposizione un’anteprima (“Preventivo online – riepilogo ordine”) dei costi e dei prodotti, anche se non si è ancora registrato. Nel caso in cui il cliente abbia bisogno di un preventivo ad hoc, può contattare telefonicamente l’azienda al numero +39 039 9151976 (dalle 9.00 alle 13.00 e dalle 14.00 alle 18.00 dal lunedì al venerdì, festivi esclusi) oppure via email all’indirizzo:&nbsp;<a href="mailto:info@gadgetaziendali.it">info@aurorapromotion.it</a>. È possibile richiedere un campione del prodotto selezionato, solo in modalità neutra (senza personalizzazione) al medesimo prezzo di spedizione indicato nel carrello. Prima di procedere all’acquisto, l’utente è tenuto a verificare i dettagli dell’ordine, chiedendo l’invio della bozza e del preventivo dello stesso, che gli sarà inviato per email. Secondo casi specifici, è possibile richiedere un campione personalizzato, al costo di vendita del prodotto con personalizzazione.</p>
                                <p>Il numero minimo di acquisto e personalizzazione è segnalato sulla pagina scheda del prodotto selezionato. Sulla stessa è possibile scegliere e selezionare il colore del prodotto, la tipologia di stampa, il numero di colori di stampa e la posizione di stampa. Nella sezione ‘Taglie’ va indicata la quantità di prodotti da personalizzare e acquistare per ogni taglia.</p>
                                <p><b>Sulla pagina della scheda del prodotto selezionato verrà richiesto all’utente di completare l’ordine attraverso il caricamento del file del contenuto che si desidera stampare. L’utente resta il solo soggetto responsabile della verifica di contenuti, ortografia e grafica dei file caricati. Al termine della selezione degli articoli desiderati, sarà visualizzata una schermata riepilogativa per la richiesta della bozza e del preventivo e per l’invio dell’ordine con indicazione dei costi e delle spese totali.</p>
                                <p><b>Pagamenti e caricamento dei contenuti</b></p>
                                <p>Il cliente potrà acquistare i prodotti online ed effettuare i pagamenti tramite carta di credito (Visa, MasterCard, American Express, a mezzo Stripe, o tramite bonifico bancario, come indicato sul Sito, seguendo le istruzioni indicate per la procedura d’acquisto.</p>
                                <p>I pagamenti devono essere effettuati anticipatamente e, solo dopo il pagamento e il caricamento del file “conforme” da parte dell’utente, gli articoli selezionati saranno messi in produzione. Per i pagamenti tramite Bonifico Bancario la produzione inizierà solo dopo l’avvenuto accredito e, di conseguenza, la consegna potrà essere posticipata di 2-3 giorni, più il tempo per la stampa e la spedizione. In questo caso è inoltre necessario inserire il numero d’ordine nella causale del versamento per identificare la transazione e i seguenti riferimenti bancari: Banca Intesa San Paolo; IBAN: IT 80 Y030 6905 0601 0000 0012 977.</p>
                                <p>La fattura sarà messa a disposizione del cliente nella propria area riservata in una sezione dedicata e sarà inviata per email successivamente alla conferma dell’ordine: sarà cura del cliente accedere a tale area, stampare il documento e conservarlo secondo le norme in vigore.</p>
                                <p><b>Responsabilità degli utenti sui contenuti caricati</b></p>
                                <p>La selezione dei contenuti e delle immagini da stampare, nonché l’acquisizione delle relative autorizzazioni alla loro riproduzione, ove necessarie, resta di esclusiva responsabilità degli utenti. AURO.RA PROMOTION S.R.L. non procederà in nessun caso alla verifica dei contenuti se non relativamente alle specifiche tecniche e alla compatibilità grafica con le specifiche richieste.</p>
                                <p>AURO.RA PROMOTION S.R.L. non potrà in alcun modo essere ritenuta responsabile per l’utilizzo non autorizzato di immagini da parte degli utenti e per ogni tipo di violazione di diritti di terzi su di esse esistenti.</p>
                                <p>L’utente esonera pertanto AURO.RA PROMOTION, impegnandosi altresì a mantenerla indenne da qualsiasi responsabilità nei confronti di terzi che dovessero lamentare violazioni di diritti di proprietà intellettuale, lesioni all’immagine, onore, decoro, integrità morale o comunque qualsiasi danno patrimoniale e non patrimoniale conseguente alla stampa delle immagini e dei contenuti caricati dall’utente stesso.</p>
                                <p>AURO.RA PROMOTION S.R.L. si riserva in ogni caso il diritto di bloccare qualsiasi ordine che comporti una evidente violazione di diritti di proprietà intellettuale di terzi o comunque i cui contenuti siano diffamatori, violenti o in altro modo contrari all’ordine pubblico e al buon costume. AURO.RA PROMOTION S.R.L. si riserva inoltre il diritto di manleva e non si ritiene responsabile per contenuti diffamatori sopra citati.</p>
                                <p><b>Verifica dei file caricati</b></p>
                                <p>Il sistema di AURO.RA PROMOTION S.R.L.verifica la compatibilità a livello di formato, dimensioni, risoluzione ed eventuale presenza di font aperti, verifica dei font e conversione di questi in tracciati, verifica di eventuali bianchi in sovrastampa e passaggio in foratura, nonché la conversione di eventuali Pantone al profilo migliore per la stampa richiesta (il sistema non informa sui colori Pantone presenti nel file, ma ne prevede direttamente la conversione in CMYK)..</p>
                                <p>In caso di non conformità con il file inviato il sistema procederà al blocco dell’ordine. In tale evenienza, l’utente sarà avvisato via e-mail e invitato a procedere nuovamente al caricamento di un nuovo file con conseguente slittamento della data di consegna.</p>
                                <p>Se il sistema non rileva difformità, il file passerà automaticamente in produzione.</p>
                                <p><b>Tempi di consegna e spedizione</b></p>
                                <p>La consegna dei prodotti verrà effettuata in concordanza ai tempi selezionati dall’utente in fase di preventivo. I termini si intendono calcolati a partire dal completamento dell’ordine, vale a dire all’esito del caricamento del file e dell’approvazione della bozza da parte dell’utente. La data fa riferimento alla consegna del prodotto al corriere e non è da intendersi vincolante.</p>
                                <p>L’ordine deve ritenersi non completato sino al momento dell’avvenuto caricamento del file da parte dell’utente e del relativo pagamento.</p>
                                <p>Per giorni lavorativi si intendono i giorni dal lunedì al venerdì con esclusione del 1/1, 6/1, 25/4, 1/5, 2/6, 15/8, 1/11, 8/12, 24/12, 25/12, 26/12, 31/12, Lunedì di Pasqua. AURO.RA PROMOTION S.R.L. non sarà responsabile in nessun caso di possibili danni provocati da ritardi nella consegna.</p>
                                <p><b>Diritto di recesso o “ripensamento”</b></p>
                                <p>L’utente ha il diritto di recedere dal contratto, senza indicarne le ragioni, entro 14 giorni e nel sono caso di acquisto di prodotti neutri. Gli articoli personalizzati non possono essere restituiti, se non nel caso di merce rovinata. Il periodo di recesso scade dopo 14 giorni dal giorno di ricezione della merce nel caso di un contratto di vendita:&nbsp;<i>in cui l’utente o un terzo, diverso dal vettore e da Lei designato, acquisisce il possesso fisico dei beni.</i>(DECRETO LEGISLATIVO 21 febbraio 2014, n. 21; attuazione della direttiva 2011/83/UE sui diritti dei consumatori, recante modifica delle direttive 93/13/CEE e 1999/44/CE e che abroga le direttive 85/577/CEE e 97/7/CE).</p>
                                <p>Per esercitare il diritto di recesso, l’utente è tenuto a informarci della sua decisione di recedere dal presente contratto tramite una dichiarazione esplicita, telefonicamente o via email:</p>
                                <p>+39 039 9151976 (dalle 9.00 alle 13.00 e dalle 14.00 alle 18.00 dal lunedì al venerdì, festivi esclusi)<br>
                                    <a href="mailto:info@aurorapromotion.it.">info@aurorapromotion.it.</a></p>
                                <p>Per rispettare il termine di recesso, è sufficiente che il cliente invii la comunicazione relativa all’esercizio del diritto di recesso prima della scadenza del periodo di recesso.</p>
                                <p><b>Effetti del recesso</b></p>
                                <p>La merce personalizzata può essere resa solo per motivi di non conformità, mentre per gli articoli non personalizzati il reso è possibile entro 14 giorni lavorativi dal ricevimento della merce.</p>
                                <p>Se l’utente recede dal presente contratto, gli saranno rimborsati tutti i pagamenti che ha effettuato a nostro favore, compresi i costi di consegna (ad eccezione dei costi supplementari derivanti dall’eventuale scelta di un tipo di consegna diverso dal tipo meno costoso di consegna standard da noi offerto), senza indebito ritardo e in ogni caso non oltre 14 giorni dal giorno in cui siamo informati della sua decisione di recedere dal presente contratto. Detti rimborsi saranno effettuati utilizzando lo stesso mezzo di pagamento usato per la transazione iniziale, salvo che non si abbia espressamente convenuto altrimenti; in ogni caso, non dovrà sostenere alcun costo quale conseguenza di tale rimborso.</p>
                                <p>L’utente è pregato di rispedire i beni o di consegnarli a noi senza indebiti ritardi e in ogni caso entro 14 giorni dal giorno in cui ci ha comunicato il suo recesso dal presente contratto. Il termine è rispettato se l’utente rispedisce i beni prima della scadenza del periodo di 14 giorni.</p>
                                <p><b>Eccezioni al Diritto di Recesso</b></p>
                                <p>Il diritto di recesso di cui agli articoli da 52 a 58 del Codice Civile per i contratti a distanza e i contratti negoziati fuori dei locali commerciali è escluso relativamente a:</p>
                                <ul>
                                    <li>i contratti di servizi dopo la completa prestazione del servizio se l’esecuzione è iniziata con l’accordo espresso del consumatore e con l’accettazione della perdita del diritto di recesso a seguito della piena esecuzione del contratto da parte del professionista;</li>
                                    <li>la fornitura di beni o servizi il cui prezzo è legato a fluttuazioni nel mercato finanziario che il professionista non è in grado di controllare e che possono verificarsi durante il periodo di recesso;</li>
                                    <li>la fornitura di beni confezionati su misura o chiaramente personalizzati;</li>
                                    <li>la fornitura di beni che rischiano di deteriorarsi o scadere rapidamente;</li>
                                    <li>la fornitura di beni sigillati che non si prestano ad essere restituiti per motivi igienici o connessi alla protezione della salute e sono stati aperti dopo la consegna;</li>
                                    <li>la fornitura di beni che, dopo la consegna, risultano, per loro natura, inscindibilmente mescolati con altri beni;</li>
                                    <li>la fornitura di bevande alcoliche, il cui prezzo sia stato concordato al momento della conclusione del contratto di vendita, la cui consegna possa avvenire solo dopo trenta giorni e il cui valore effettivo dipenda da fluttuazioni sul mercato che non possono essere controllate dal professionista;</li>
                                    <li>i contratti in cui il consumatore ha specificamente richiesto una visita da parte del professionista ai fini dell’effettuazione di lavori urgenti di riparazione o manutenzione. Se, in occasione di tale visita, il professionista fornisce servizi oltre a quelli specificamente richiesti dal consumatore o beni diversi dai pezzi di ricambio necessari per effettuare la manutenzione o le riparazioni, il diritto di recesso si applica a tali servizi o beni supplementari;</li>
                                    <li>la fornitura di registrazioni audio o video sigillate o di software informatici sigillati che sono stati aperti dopo la consegna;</li>
                                    <li>la fornitura di giornali, periodici e riviste ad eccezione dei contratti di abbona-mento per la fornitura di tali pubblicazioni;</li>
                                    <li>i contratti conclusi in occasione di un’asta pubblica;</li>
                                    <li>la fornitura di alloggi per fini non residenziali, il trasporto di beni, i servizi di noleggio di autovetture, i servizi di catering o i servizi riguardanti le attività del tempo libero qualora il contratto preveda una data o un periodo di esecuzione specifici;</li>
                                    <li>la fornitura di contenuto digitale mediante un supporto non materiale se l’esecuzione è iniziata con l’accordo espresso del consumatore e con la sua accettazione del fatto che in tal caso avrebbe perso il diritto di recesso.</li>
                                </ul>
                                <p><b>Esonero di responsabilità – vizi dei prodotti</b></p>
                                <p>AURO.RA PROMOTION S.R.L. non sarà responsabile nei confronti dell’utente per danni di qualsiasi specie, sia diretti che indiretti, derivanti da eventuali errori, di ogni natura, nella stampa del file inviato dal cliente, salvo dolo o colpa grave.</p>
                                <p>In caso di errori di stampa non imputabili all’utente oppure di consegna di prodotto difettato o danneggiato, AURO.RA PROMOTION S.R.L. sarà tenuta esclusivamente a eseguire una sola ristampa del materiale.</p>
                                <p>Al momento della consegna l’utente è tenuto a esaminare attentamente i prodotti ricevuti. Eventuali vizi della merce consegnata, errori nella stampa o nel confezionamento del materiale non imputabili all’utente, vanno segnalati immediatamente al corriere o al servizio d’assistenza al cliente. La merce deve essere ritirata apponendo firma con riserva specifica di controllo. L’utente dovrà poi aprire una segnalazione tramite posta elettronica, avendo cura di allegare la documentazione fotografica ove richiesto entro 8 giorni dalla ricezione del materiale.</p>
                                <p>AURO.RA PROMOTION S.R.L. farà del proprio meglio per rispondere alle segnalazioni ricevute entro due ore.</p>
                                <p><b>Legge applicabile, giurisdizione e foro competente per utenti non consumatori</b></p>
                                <p>Le presenti Condizioni sono soggette alla legge Italiana.</p>
                            </div>
                        </div><!-- .terms-list END -->
                    </div><!-- .terms-list-group END -->
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </div><!-- End terms and condition section -->

@endsection

@section('extra-css')
    <style>
        .media-body li {
            color: #555555;
            list-style: inherit;
        }
        .media-body ul {
            color: #555555;
            list-style: inherit;
            margin: 0 30px 10px;
        }
        .terms-list.media .media-body p b {
            color: #555555;
        }
    </style>
@endsection

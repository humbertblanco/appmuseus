<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Índex --}}
        <x-filament::section>
            <x-slot name="heading">Índex</x-slot>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <a href="#exposicions" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-building-library class="w-4 h-4" /> 1. Gestió d'exposicions
                </a>
                <a href="#peces" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-puzzle-piece class="w-4 h-4" /> 2. Gestió de sales/peces
                </a>
                <a href="#idiomes" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-language class="w-4 h-4" /> 3. Sistema multilingüe
                </a>
                <a href="#audio" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-speaker-wave class="w-4 h-4" /> 4. Àudios i accessibilitat
                </a>
                <a href="#qr" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-qr-code class="w-4 h-4" /> 5. Codis QR
                </a>
                <a href="#redireccions" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-arrow-uturn-right class="w-4 h-4" /> 6. Redireccions
                </a>
                <a href="#estadistiques" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-chart-bar class="w-4 h-4" /> 7. Estadístiques
                </a>
                <a href="#dashboard" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-squares-2x2 class="w-4 h-4" /> 8. Dashboard (widgets)
                </a>
                <a href="#exportar" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> 9. Exportar dades
                </a>
                <a href="#usuaris" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-users class="w-4 h-4" /> 10. Usuaris i seguretat
                </a>
                <a href="#frontend" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-device-phone-mobile class="w-4 h-4" /> 11. Com funciona el frontend
                </a>
                <a href="#consells" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    <x-heroicon-o-light-bulb class="w-4 h-4" /> 12. Consells i bones pràctiques
                </a>
            </div>
        </x-filament::section>

        {{-- 1. Exposicions --}}
        <x-filament::section id="exposicions">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-building-library class="w-5 h-5 text-primary-500" />
                    1. Gestió d'exposicions
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <p>Les <strong>exposicions</strong> són el nivell principal de contingut. Cada exposició representa un museu o espai expositiu.</p>

                <h4>Camps principals</h4>
                <ul>
                    <li><strong>URL:</strong> Identificador únic per a la URL (ex: <code>exposicio-principal</code>). Un cop creat, millor no canviar-lo perquè afecta les URLs i QRs.</li>
                    <li><strong>Imatge de portada:</strong> Imatge principal que es mostra a la Home.</li>
                    <li><strong>Ordre:</strong> Número per ordenar les exposicions a la Home (menor = primer).</li>
                    <li><strong>Visible:</strong> Si està desactivada, no es mostra al públic però es manté a l'admin.</li>
                </ul>

                <h4>Traduccions (per idioma)</h4>
                <p>Cada exposició té traduccions en 4 idiomes (CA, ES, EN, FR) amb:</p>
                <ul>
                    <li><strong>Títol i descripció</strong> de l'exposició</li>
                    <li><strong>Informació de contacte:</strong> adreça, telèfon, email</li>
                    <li><strong>Enllaços:</strong> web, Facebook, Instagram</li>
                </ul>
                <p>Si deixes el títol buit en un idioma, la traducció no es guardarà.</p>

                <h4>Documents / Fulls de sala</h4>
                <p>PDFs descarregables per idioma (fulls de sala, guies en paper, etc.). Cada document té títol, descripció opcional, fitxer PDF i ordre.</p>

                <h4>Crear una exposició nova</h4>
                <ol>
                    <li>Anar a <strong>Contingut → Exposicions → Crear</strong></li>
                    <li>Omplir el slug (minúscules, guions)</li>
                    <li>Pujar la imatge de portada</li>
                    <li>Omplir les traduccions (mínim català)</li>
                    <li>Afegir informació de contacte</li>
                    <li>Opcionalment afegir documents PDF</li>
                    <li>Desar</li>
                </ol>
            </div>
        </x-filament::section>

        {{-- 2. Peces --}}
        <x-filament::section id="peces">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-puzzle-piece class="w-5 h-5 text-primary-500" />
                    2. Gestió de sales / peces
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <p>Les <strong>peces</strong> (o sales) són els elements individuals dins d'una exposició. Cada peça representa una sala, obra o punt d'interès amb el seu àudio i informació.</p>

                <h4>Camps principals</h4>
                <ul>
                    <li><strong>Exposició:</strong> A quina exposició pertany (obligatori).</li>
                    <li><strong>URL:</strong> Identificador únic per a la URL dins de l'exposició.</li>
                    <li><strong>Ordre:</strong> Per ordenar les peces dins l'exposició. Es pot reordenar arrossegant.</li>
                    <li><strong>Visible:</strong> Mostra/oculta al públic.</li>
                </ul>

                <h4>Galeria d'imatges</h4>
                <ul>
                    <li>Fins a <strong>20 imatges</strong> per peça (JPG, PNG, màx. 5MB)</li>
                    <li>Reordenables arrossegant</li>
                    <li>La primera imatge es mostra com a miniatura al llistat</li>
                </ul>

                <h4>Traduccions (per idioma)</h4>
                <p>Cada peça té traduccions en 4 idiomes amb:</p>
                <ul>
                    <li><strong>Títol:</strong> Nom de la peça/sala</li>
                    <li><strong>Subtítol:</strong> Autor, artista, o informació secundària</li>
                    <li><strong>Subtítol 2:</strong> Dates o època (ex: "1920-1925")</li>
                    <li><strong>Descripció:</strong> Text complet explicatiu</li>
                    <li><strong>Àudio:</strong> Fitxer MP3/WAV de l'audioguia (màx. 30MB)</li>
                </ul>

                <h4>Indicadors a la taula</h4>
                <p>Al llistat de peces, veuràs icones indicadores:</p>
                <ul>
                    <li><strong>AD</strong> (blau): Té audiodescripció per a persones cegues</li>
                    <li><strong>LSC</strong> (verd): Té vídeo en llengua de signes</li>
                    <li><strong>TXT</strong> (groc): Té transcripció de l'audiodescripció</li>
                </ul>

                <h4>Crear una peça nova</h4>
                <ol>
                    <li>Anar a <strong>Contingut → Sales/Peces → Crear</strong></li>
                    <li>Seleccionar l'exposició</li>
                    <li>Omplir slug</li>
                    <li>Pujar imatges a la galeria</li>
                    <li>Omplir traduccions per cada idioma (mínim títol en català)</li>
                    <li>Pujar àudios de l'audioguia per cada idioma</li>
                    <li>Opcionalment afegir audiodescripcions i materials</li>
                    <li>Desar</li>
                </ol>
            </div>
        </x-filament::section>

        {{-- 3. Idiomes --}}
        <x-filament::section id="idiomes">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-language class="w-5 h-5 text-primary-500" />
                    3. Sistema multilingüe
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Idiomes disponibles</h4>
                <table>
                    <thead>
                        <tr><th>Codi</th><th>Idioma</th><th>Per defecte</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><code>ca</code></td><td>Català</td><td>Sí</td></tr>
                        <tr><td><code>es</code></td><td>Castellà</td><td>No</td></tr>
                        <tr><td><code>en</code></td><td>Anglès</td><td>No</td></tr>
                        <tr><td><code>fr</code></td><td>Francès</td><td>No</td></tr>
                    </tbody>
                </table>

                <h4>Com funciona</h4>
                <ul>
                    <li>L'idioma es guarda en una <strong>cookie</strong> al navegador del visitant (durada 30 dies).</li>
                    <li>El visitant pot canviar l'idioma amb el <strong>selector d'idioma</strong> que apareix a cada pàgina.</li>
                    <li>Les URLs inclouen el prefix d'idioma: <code>/ca/</code>, <code>/es/</code>, <code>/en/</code>, <code>/fr/</code></li>
                    <li>Si un idioma no té traducció, es mostra el contingut en català com a fallback.</li>
                </ul>

                <h4>A l'admin</h4>
                <p>Cada exposició i peça té <strong>pestanyes per idioma</strong>. El contingut en català és el mínim recomanat. Si deixes el títol buit en un idioma, aquella traducció no es guardarà.</p>

                <h4>Consell</h4>
                <p>Intenta mantenir totes les traduccions al dia. Les estadístiques d'idiomes al dashboard et mostren quins idiomes fan servir els visitants.</p>
            </div>
        </x-filament::section>

        {{-- 4. Àudios i accessibilitat --}}
        <x-filament::section id="audio">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-speaker-wave class="w-5 h-5 text-primary-500" />
                    4. Àudios i accessibilitat
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Àudio principal (audioguia)</h4>
                <ul>
                    <li>Cada peça pot tenir un <strong>àudio per idioma</strong> (MP3 o WAV, màx. 30MB)</li>
                    <li>És l'àudio que escolten els visitants quan visiten la peça</li>
                    <li>Es puja des de la pestanya de l'idioma corresponent</li>
                </ul>

                <h4>Audiodescripció (accessibilitat visual)</h4>
                <p>Per a visitants amb discapacitat visual:</p>
                <ul>
                    <li><strong>Àudio d'audiodescripció:</strong> Un àudio específic que descriu visualment l'obra</li>
                    <li><strong>Transcripció:</strong> Text alternatiu per a qui no pot escoltar l'àudio</li>
                    <li>S'accedeix amb el paràmetre <code>?ad=1</code> a la URL o amb QR específics d'audiodescripció</li>
                </ul>

                <h4>Llengua de signes (Mirada Tàctil)</h4>
                <ul>
                    <li>Vídeos en LSC (Llengua de Signes Catalana) proporcionats per Mirada Tàctil</li>
                    <li>S'afegeixen com a <strong>material addicional</strong> de tipus "Signes"</li>
                    <li>Apareixen amb una icona especial a la pàgina de la peça</li>
                </ul>

                <h4>Materials addicionals</h4>
                <p>Cada peça pot tenir materials extra per idioma:</p>
                <table>
                    <thead>
                        <tr><th>Tipus</th><th>Descripció</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>PDF</strong></td><td>Document descarregable (fitxa tècnica, etc.)</td></tr>
                        <tr><td><strong>Enllaç</strong></td><td>URL externa relacionada</td></tr>
                        <tr><td><strong>Vídeo</strong></td><td>URL d'un vídeo (YouTube, Vimeo, etc.)</td></tr>
                        <tr><td><strong>Signes</strong></td><td>Vídeo en llengua de signes (Mirada Tàctil)</td></tr>
                    </tbody>
                </table>

                <h4>Widget d'accessibilitat al frontend</h4>
                <p>Els visitants tenen un botó d'accessibilitat (cantonada inferior dreta) que permet:</p>
                <ul>
                    <li>Canviar la <strong>mida de la lletra</strong> (normal, gran, molt gran)</li>
                    <li>Activar el <strong>mode d'alt contrast</strong></li>
                    <li>La configuració es guarda al navegador</li>
                </ul>
            </div>
        </x-filament::section>

        {{-- 5. QR --}}
        <x-filament::section id="qr">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-qr-code class="w-5 h-5 text-primary-500" />
                    5. Codis QR
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Tipus de QR</h4>
                <table>
                    <thead>
                        <tr><th>Tipus</th><th>Per a</th><th>Paràmetre</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>QR estàndard</strong></td><td>Audioguia normal</td><td><code>?qr=1</code></td></tr>
                        <tr><td><strong>QR audiodescripció</strong></td><td>Versió per a persones cegues</td><td><code>?qr=1&ad=1</code></td></tr>
                    </tbody>
                </table>

                <h4>Com generar QRs</h4>
                <ol>
                    <li>Anar a l'<strong>edició</strong> d'una peça o exposició</li>
                    <li>Clicar el botó <strong>"QR"</strong> a la capçalera</li>
                    <li>Es mostren QRs per cada idioma (4 QRs estàndard + 4 QRs d'audiodescripció per peces)</li>
                    <li>Les exposicions permeten <strong>descarregar en PNG</strong> (500x500px) per imprimir</li>
                </ol>

                <h4>Com funciona el seguiment</h4>
                <ul>
                    <li>Quan un visitant escaneja un QR, el paràmetre <code>?qr=1</code> identifica la visita com a <strong>"QR scan"</strong></li>
                    <li>Això es registra automàticament a les estadístiques</li>
                    <li>Permet diferenciar entre visitants que venen per QR i els que arriben pel web</li>
                </ul>

                <h4>Consells per imprimir QRs</h4>
                <ul>
                    <li>Utilitza la descàrrega PNG (500x500px) per a cartells</li>
                    <li>Afegeix al costat del QR l'idioma al qual apunta</li>
                    <li>Es recomana posar QRs en català i castellà com a mínim</li>
                    <li>Per audiodescripció, indica-ho clarament al costat del QR</li>
                </ul>
            </div>
        </x-filament::section>

        {{-- 6. Redireccions --}}
        <x-filament::section id="redireccions">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrow-uturn-right class="w-5 h-5 text-primary-500" />
                    6. Redireccions
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <p>Les redireccions serveixen per mantenir les <strong>URLs antigues</strong> funcionant quan el contingut canvia de lloc.</p>

                <h4>Quan usar-les</h4>
                <ul>
                    <li>Si canvies el slug d'una peça o exposició</li>
                    <li>Si migres contingut d'una web antiga</li>
                    <li>Si vols crear URLs curtes que apuntin a contingut existent</li>
                </ul>

                <h4>Camps</h4>
                <ul>
                    <li><strong>Origen:</strong> L'URL antiga, sense el domini (ex: <code>/antiga-pagina</code>)</li>
                    <li><strong>Destí:</strong> L'URL nova (ex: <code>/ca/exposicio/la-meva-exposicio</code>)</li>
                    <li><strong>Tipus:</strong>
                        <ul>
                            <li><strong>301 (Permanent):</strong> Per canvis definitius. Els cercadors actualitzen els seus índexs.</li>
                            <li><strong>302 (Temporal):</strong> Per canvis temporals. Els cercadors mantenen la URL original.</li>
                        </ul>
                    </li>
                    <li><strong>Activa:</strong> Activa/desactiva la redirecció</li>
                </ul>

                <h4>Seguiment</h4>
                <p>Les visites via redirecció es registren com a tipus <strong>"Redirecció"</strong> a les estadístiques, per diferenciar-les de les visites directes.</p>

                <h4>Memòria cau</h4>
                <p>Les redireccions es guarden en memòria cau durant 5 minuts. Quan crees o modifiques una redirecció, la memòria cau s'esborra automàticament.</p>
            </div>
        </x-filament::section>

        {{-- 7. Estadístiques --}}
        <x-filament::section id="estadistiques">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-chart-bar class="w-5 h-5 text-primary-500" />
                    7. Estadístiques
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Què es registra</h4>
                <p>Cada visita d'un visitant real (no bots) es registra amb:</p>
                <table>
                    <thead>
                        <tr><th>Camp</th><th>Descripció</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Peça/Exposició</strong></td><td>Quin contingut ha vist</td></tr>
                        <tr><td><strong>Tipus</strong></td><td>QR scan, visita web, o redirecció</td></tr>
                        <tr><td><strong>Idioma</strong></td><td>Quin idioma tenia seleccionat</td></tr>
                        <tr><td><strong>Dispositiu</strong></td><td>Mòbil, tauleta o escriptori</td></tr>
                        <tr><td><strong>Visitant</strong></td><td>Identificador anònim (cookie, 1 any)</td></tr>
                        <tr><td><strong>IP (hash)</strong></td><td>Hash SHA256 de la IP (no es guarda la IP real)</td></tr>
                    </tbody>
                </table>

                <h4>Tipus de visita</h4>
                <ul>
                    <li><span class="inline-flex items-center rounded-md bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20">QR</span> El visitant ha escanejat un codi QR físic</li>
                    <li><span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-blue-600/20 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20">Web</span> El visitant ha accedit directament per la web</li>
                    <li><span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20">Redir</span> El visitant ha arribat via una redirecció configurada</li>
                </ul>

                <h4>Filtrat de bots</h4>
                <p>El sistema filtra automàticament les visites de:</p>
                <ul>
                    <li>Cercadors (Google, Bing, Yahoo, etc.)</li>
                    <li>Xarxes socials (Facebook, Twitter, WhatsApp previsualitzacions)</li>
                    <li>Eines de monitoratge (Lighthouse, PageSpeed, GTmetrix, Pingdom, UptimeRobot)</li>
                    <li>Scripts automàtics (curl, wget, Python, etc.)</li>
                </ul>
                <p>Això garanteix que les estadístiques reflecteixin <strong>visitants reals</strong>.</p>

                <h4>Deduplicació</h4>
                <p>Per evitar comptar la mateixa visita múltiples vegades:</p>
                <ul>
                    <li>Cada visitant té un <strong>identificador anònim</strong> (cookie de 1 any)</li>
                    <li>Si un visitant torna a la mateixa peça dins de <strong>30 minuts</strong>, no es compta de nou</li>
                    <li>Això evita inflació de números per refrescos de pàgina</li>
                </ul>

                <h4>Filtres disponibles</h4>
                <p>A la pàgina d'estadístiques pots filtrar per: tipus, idioma, dispositiu, exposició i peça. Les dades s'actualitzen automàticament cada 30 segons.</p>
            </div>
        </x-filament::section>

        {{-- 8. Dashboard --}}
        <x-filament::section id="dashboard">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-squares-2x2 class="w-5 h-5 text-primary-500" />
                    8. Dashboard (widgets)
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <p>El dashboard mostra un resum visual de l'activitat. Els widgets estan ordenats per importància:</p>

                <h4>1. Resum general</h4>
                <p>Targetes amb les dades més importants:</p>
                <ul>
                    <li><strong>Avui:</strong> Total de visites d'avui (QR + web + redireccions)</li>
                    <li><strong>Visitants únics avui:</strong> Persones diferents que han visitat avui</li>
                    <li><strong>Última setmana:</strong> Total de la setmana</li>
                    <li><strong>Visitants únics setmana:</strong> Persones diferents de la setmana</li>
                    <li><strong>Total:</strong> Acumulat de totes les visites</li>
                </ul>

                <h4>2. Taxa de completitud</h4>
                <ul>
                    <li><strong>Visitants únics (30 dies):</strong> Quantes persones han visitat en el darrer mes</li>
                    <li><strong>Mitjana peces visitades:</strong> Quantes peces visita de mitjana cada visitant (i percentatge del recorregut complet)</li>
                    <li><strong>Visitants amb recorregut:</strong> Quants visitants han vist 2 o més peces</li>
                </ul>
                <p>Això és útil per saber si els visitants completen el recorregut o s'aturen aviat.</p>

                <h4>3. Gràfic de visites (30 dies)</h4>
                <p>Gràfic de línies amb l'evolució diària de QR scans (verd), visites web (blau) i redireccions (taronja).</p>

                <h4>4. Idiomes i dispositius</h4>
                <p>Dos gràfics circulars que mostren:</p>
                <ul>
                    <li><strong>Distribució d'idiomes:</strong> Quin percentatge de visitants fa servir cada idioma</li>
                    <li><strong>Dispositius:</strong> Mòbil vs escriptori vs tauleta (últims 30 dies)</li>
                </ul>

                <h4>5. Hores punta</h4>
                <p>Gràfic de barres amb les hores de més activitat (8h-21h, últims 30 dies). Útil per saber quan hi ha més visitants.</p>

                <h4>6. Top peces visitades</h4>
                <p>Taula amb les 10 peces més visitades, amb detall de visites QR, web, visitants únics i total.</p>

                <h4>7. Recorregut dels últims visitants</h4>
                <p>Mostra els últims 20 visitants amb el seu recorregut: data, idioma, dispositiu, peces visitades en ordre, si van usar QR, i total de pàgines vistes.</p>
            </div>
        </x-filament::section>

        {{-- 9. Exportar --}}
        <x-filament::section id="exportar">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 text-primary-500" />
                    9. Exportar dades
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Com exportar</h4>
                <ol>
                    <li>Anar a <strong>Estadistiques → Exportar</strong> (o des del botó "Exportar" a la llista d'estadístiques)</li>
                    <li>Seleccionar el <strong>rang de dates</strong></li>
                    <li>Opcionalment aplicar filtres: exposició, tipus, idioma, dispositiu</li>
                    <li>Veuràs el <strong>nombre de registres</strong> que s'exportaran</li>
                    <li>Escollir <strong>format</strong>: Excel (.xlsx) o CSV (.csv)</li>
                    <li>Clicar <strong>Exportar</strong></li>
                </ol>

                <h4>Camps exportats</h4>
                <table>
                    <thead>
                        <tr><th>Camp</th><th>Descripció</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>ID</td><td>Identificador únic del registre</td></tr>
                        <tr><td>Data</td><td>Dia de la visita (dd/mm/aaaa)</td></tr>
                        <tr><td>Hora</td><td>Hora de la visita (hh:mm:ss)</td></tr>
                        <tr><td>Tipus</td><td>QR, Web, o Redirecció</td></tr>
                        <tr><td>Idioma</td><td>Idioma del visitant</td></tr>
                        <tr><td>Dispositiu</td><td>Mòbil, tauleta, o escriptori</td></tr>
                        <tr><td>Exposició</td><td>Nom de l'exposició visitada</td></tr>
                        <tr><td>Peça</td><td>Nom de la peça visitada</td></tr>
                        <tr><td>Visitant</td><td>ID anònim del visitant</td></tr>
                        <tr><td>User Agent</td><td>Informació del navegador</td></tr>
                    </tbody>
                </table>

                <h4>Consells</h4>
                <ul>
                    <li>Excel és millor per anàlisi i gràfics</li>
                    <li>CSV és millor per importar a altres sistemes</li>
                    <li>Exporta periòdicament per tenir còpia de seguretat de les dades</li>
                </ul>
            </div>
        </x-filament::section>

        {{-- 10. Usuaris --}}
        <x-filament::section id="usuaris">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-users class="w-5 h-5 text-primary-500" />
                    10. Usuaris i seguretat
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Rols disponibles</h4>
                <table>
                    <thead>
                        <tr><th>Rol</th><th>Permisos</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Super Admin</strong></td>
                            <td>Accés total: contingut, estadístiques, redireccions, usuaris, exportació</td>
                        </tr>
                        <tr>
                            <td><strong>Editor</strong></td>
                            <td>Pot gestionar exposicions i peces. Pot veure estadístiques. No pot gestionar usuaris ni redireccions.</td>
                        </tr>
                    </tbody>
                </table>

                <h4>Mesures de seguretat actives</h4>
                <ul>
                    <li><strong>Protecció contra força bruta:</strong> Màxim 5 intents de login per minut per IP. Després es bloqueja temporalment.</li>
                    <li><strong>Contrasenyes segures:</strong> Xifratge bcrypt amb 12 rondes (estàndard de la indústria).</li>
                    <li><strong>HTTPS:</strong> Tota la comunicació web va xifrada amb SSL.</li>
                    <li><strong>CSRF:</strong> Protecció contra atacs de falsificació de peticions.</li>
                    <li><strong>Cookies segures:</strong> Sessions HTTP-only (no accessibles des de JavaScript maliciós).</li>
                    <li><strong>Privacitat de visitants:</strong> Les IPs es guarden com a hash SHA256, no en text pla. L'identificador de visitant és anònim.</li>
                </ul>

                <h4>Gestionar usuaris</h4>
                <p>Només els Super Admin poden accedir a <strong>Configuració → Usuaris</strong> per crear, editar o eliminar usuaris.</p>

                <h4>Bones pràctiques</h4>
                <ul>
                    <li>Fes servir contrasenyes fortes (mínim 12 caràcters)</li>
                    <li>Crea un usuari editor per a persones que només necessiten editar contingut</li>
                    <li>No comparteixis contrasenyes entre usuaris</li>
                </ul>
            </div>
        </x-filament::section>

        {{-- 11. Frontend --}}
        <x-filament::section id="frontend">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-device-phone-mobile class="w-5 h-5 text-primary-500" />
                    11. Com funciona el frontend
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Estructura de les pàgines</h4>
                <ul>
                    <li><strong>Home:</strong> Llista de totes les exposicions actives amb imatge, títol i nombre de peces</li>
                    <li><strong>Exposició:</strong> Descripció de l'exposició, informació de contacte, documents descarregables, i llistat de peces</li>
                    <li><strong>Peça:</strong> Galeria d'imatges, àudio de l'audioguia, descripció, materials addicionals, audiodescripció (si disponible)</li>
                </ul>

                <h4>Navegació del visitant</h4>
                <ol>
                    <li>El visitant arriba a la Home (o escaneja un QR d'una exposició)</li>
                    <li>Selecciona una exposició</li>
                    <li>Navega entre les peces de l'exposició</li>
                    <li>Escolta els àudios, veu les imatges i materials</li>
                    <li>Pot canviar l'idioma en qualsevol moment</li>
                    <li>Pot ajustar l'accessibilitat (mida lletra, contrast)</li>
                </ol>

                <h4>URLs</h4>
                <p>Les URLs segueixen aquesta estructura:</p>
                <ul>
                    <li>Home: <code>/</code></li>
                    <li>Exposició: <code>/{idioma}/exposicio/{slug}</code></li>
                    <li>Peça: <code>/{idioma}/peca/{slug}</code></li>
                    <li>Canviar idioma: <code>/idioma/{codi}</code></li>
                </ul>

                <h4>Responsiu</h4>
                <p>El disseny s'adapta a tots els dispositius: mòbils, tauletes i escriptori. La majoria de visitants (especialment al museu) faran servir el mòbil.</p>
            </div>
        </x-filament::section>

        {{-- 12. Consells --}}
        <x-filament::section id="consells">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-light-bulb class="w-5 h-5 text-primary-500" />
                    12. Consells i bones pràctiques
                </div>
            </x-slot>

            <div class="prose dark:prose-invert max-w-none text-sm">
                <h4>Contingut</h4>
                <ul>
                    <li><strong>URLs:</strong> Un cop creada una URL i generat el QR, no la canviïs. Si ho fas, crea una redirecció.</li>
                    <li><strong>Imatges:</strong> Optimitza les imatges abans de pujar-les (màxim 2000px d'ample, format JPG).</li>
                    <li><strong>Àudios:</strong> Format MP3 és l'ideal. Intenta que no superin els 5-10 minuts per peça.</li>
                    <li><strong>Traduccions:</strong> Prioritza català i castellà. Anglès i francès si tens recursos.</li>
                </ul>

                <h4>Estadístiques</h4>
                <ul>
                    <li>Revisa el dashboard setmanalment per veure tendències.</li>
                    <li>El gràfic d'idiomes t'indica si val la pena invertir en traduccions addicionals.</li>
                    <li>El gràfic d'hores punta ajuda a planificar horaris de personal.</li>
                    <li>La taxa de completitud indica si el recorregut és massa llarg o curt.</li>
                    <li>Exporta les dades mensualment com a còpia de seguretat.</li>
                </ul>

                <h4>QR Codes</h4>
                <ul>
                    <li>Imprimeix els QR a mida suficient (mínim 3x3 cm).</li>
                    <li>Col·loca'ls a prop de cada peça, a l'alçada dels ulls.</li>
                    <li>Indica l'idioma al costat de cada QR.</li>
                    <li>Si ofereixes audiodescripció, col·loca QRs addicionals amb indicació tàctil.</li>
                </ul>

                <h4>Rendiment</h4>
                <ul>
                    <li>Les redireccions es guarden en memòria cau (5 minuts).</li>
                    <li>Les estadístiques del dashboard es calculen en temps real.</li>
                    <li>Si el sistema va lent, revisa que no hi hagi massa registres d'estadístiques (pots exportar i netejar els antics).</li>
                </ul>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>

    <div id="home">
        <h2>Pi Burgers <span>Vos sabés como son</span></h2>
    </div>
    
    <div class= 'error'><?= isset($_SESSION['error']) ? $aErrores['denegado'] : ''; ?></div>

    <section>
       <div>
        <h2>Nosotros</h2>

        <p>Nació en 2012, la pasión por la gastronomía y el emprendimiento nos llevó a unirnos con MAXHENRI GROUP y así, ese mismo año, en el corazón de Palermo Soho abrimos nuestra primera tienda tras dos años de planear la apertura, convirtiéndonos en la primera hamburguesería GREEN de la Argentina.</p>

        <p>La pasión por la comida se vive a diario en nuestros locales, impulsada por el concepto de FastGood, que destaca lo rápido y bueno. <span> La elaboración de productos con altos estándares de calidad, la mezcla de ingredientes frescos, caseros y procesos artesanales nos permiten brindar a nuestros clientes una experiencia única, para que disfruten de las mejores hamburguesas, fries, hotdogs, limonadas, cervezas y vinos en un ambiente relajado y moderno, con la mejor música y atención personalizada.</span></p>
        </div>
        <div></div>
    </section>

    <section>
        <h2>Nuestros especiales</h2>

        <p>Disfrutá de nuestras mejores comidas con un 20% de descuento. <span>Válido del 31/05/2019 al 30/06/2019.</span></p>
        
        <ul class="especial">
            <li>
                <figure><img src="img/platos/smoked-index.jpg" alt="Smoked Burger"></figure>
            </li>
            <li>
                <figure><img src="img/platos/fries-index.jpg" alt="Fries"></figure>
            </li>
            <li>
                <figure><img src="img/platos/mush-index.jpg" alt="Mush Burger"></figure>
            </li>
        </ul>
    </section>

    <section>
        <h2>Reviews</h2>

        <ul class="reviews" id="rev">
            <li >
               <div>
                <p id='vanjie'><cite>Vanjie Mateo</cite></p>
                <blockquote>No conocía el lugar y realmente me sorprendió gratamente. El local es muy amplio, cómodo, limpio y el personal es muy atento. Las opciones de menú son buenas, ya que la calidad es muy buena y los precios son razonables. Excelente local.</blockquote>
                </div>
            </li>
            <li >
               <div>
                <p id='su'><cite>Susana Albizu</cite></p>
                <blockquote>Buenas opciones de comida rápida. Las hamburguesas parecen caseras y las papas se pueden pedir de varias maneras. El local es muy limpio y espacioso, con onda familiar pero tranquilo.</blockquote>
                </div>
            </li>
            <li >
               <div>
                <p id='maik'><cite>Ivan Peréz</cite></p>
                <blockquote>El local es muy lindo y moderno. Tienen hamburguesas para todos los gustos. Hay opción vegetariana de hamburguesa de hongos, muy rica por cierto. Comida rápida con onda. Me gustó! Los precios son razonables. Lo recomiendo para ir con niños.</blockquote>
                </div>
            </li>
            <li >
               <div>
                <p id='marga'><cite>Margarita García del Río</cite></p>
                <blockquote>Comí un combo de $229 y quedé fascinada. El sabor de la hamburguesa es increíble y el tamaño es el adecuado para un adulto. Las papas y su particular forma son más sabrosas que en cadenas similares y la limonada es una excelente alternativa. Muy recomendable.</blockquote>
                </div>
            </li>
            <li>
               <div>
                <p  id='sab'><cite>Sabrina Introini</cite></p>
                <blockquote>El lugar es agradable, suele haber mucha gente pero tienen un sistema eficiente que te avisa cuando está tu pedido. Los precios son razonables, la atención buena y los baños estaban limpios. Lo recomendaría.</blockquote>
                </div>
            </li>
        </ul>
    </section>
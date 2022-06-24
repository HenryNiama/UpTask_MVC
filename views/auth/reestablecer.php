<div class="contenedor reestablecer">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo Password</p>
        
        <form class="formulario" action="/reestablecer" method="POST">

            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <div class="campo">
                <label for="password2">Repite tu Password:</label>
                <input 
                    type="password" 
                    id="password2"
                    placeholder="Repite tu Password"
                    name="password2"
                />
            </div>

            <input type="submit" class="boton" value="Guardar Password">

        </form>

        <div class="acciones">
            <a href="/crear">Aún no tienes una cuenta? Obtén una!</a>
            <a href="/olvide">Olvidaste tu Password?</a>
        </div>
        
    </div> <!--contenedor-sm-->

</div>
<?php
/*
Plugin Name: Boton de Contacto flotante
Description: Agrega un botón flotante en la página web que permite a los usuarios interactuar fácilmente a través de varios canales de comunicación.
Author: Imagining Wolf
Author URI: https://renovate.com.mx//
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cost-calculator-builder
Version: 1.5
 */

// Añadir el botón flotante al pie de página
function fbw_add_floating_button() {
    // Obtener los enlaces configurados en el panel de administración
    $whatsapp_link = get_option('whatsapp_link', '');
    $facebook_link = get_option('facebook_link', '');
    $instagram_link = get_option('instagram_link', '');
    $call_link = get_option('call_link', '');
    $email_link = get_option('email_link', '');
    $location_link = get_option('location_link', '');
    $tiktok_link = get_option('tiktok_link', '');
    $messenger_link = get_option('messenger_link', '');
    $telegram_link = get_option('telegram_link', '');
    $mobile_margin_bottom = get_option('mobile_margin_bottom', '60px');
    $mobile_margin_left_right = get_option('mobile_margin_left_right', '25px');
    $desktop_margin_bottom = get_option('desktop_margin_bottom', '60px');
    $desktop_margin_left_right = get_option('desktop_margin_left_right', '60px');
    $button_color = get_option('button_color', '#00bbff');
    $icon_color = get_option('icon_color', '#ffffff');
    $button_hover_color = get_option('button_hover_color', '#009fd9');
    $icon_hover_color = get_option('icon_hover_color', '#bfbfbf');
    $button_animation = get_option('button_animation', 'slide-up'); // Animación del botón de entrada
    $post_animation = get_option('post_animation', 'bounce'); // Animación después de entrada (rebote o pulsar)

    ?>
    <style>
        /* Estilos personalizados desde el panel */
.floating-btn {
    position: fixed;
    bottom: <?php echo esc_attr($desktop_margin_bottom); ?>;
    right: 20px; /* El botón siempre estará a la derecha */
    background-color: <?php echo esc_attr($button_color); ?>;
    color: <?php echo esc_attr($icon_color); ?>;
    border: none;
    border-radius: 50%;
    padding: 15px;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    z-index: 1000;
    transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
    width: 60px; /* Establecer tamaño fijo para el botón flotante */
    height: 60px; /* Establecer tamaño fijo para el botón flotante */
    animation: <?php echo esc_attr($button_animation); ?> 0.5s ease-in-out forwards; /* Animación de entrada */
    box-shadow: 0 0 10px <?php echo esc_attr($button_color); ?>; /* Brillo al mismo color del botón */
}

.floating-btn:hover {
    background-color: <?php echo esc_attr($button_hover_color); ?>;
    color: <?php echo esc_attr($icon_hover_color); ?>;
}

/* Estilo para el contenedor de iconos flotantes */
.floating-icons {
    position: fixed;
    bottom: calc(<?php echo esc_attr($desktop_margin_bottom); ?> + 70px); /* Alinea los iconos justo debajo del botón principal */
    right: 20px; /* El contenedor de iconos siempre estará a la derecha */
    display: none;
    flex-direction: column;
    gap: 10px;
    z-index: 999;
    transition: bottom 0.3s ease-in-out;
}

.floating-icons.show {
    display: flex; /* Asegura que se muestren al abrir */
}

/* Animaciones del botón principal */
        @keyframes slideUp {
            0% {
                bottom: -100px;
            }
            100% {
                bottom: <?php echo esc_attr($desktop_margin_bottom); ?>;
            }
        }

        @keyframes scaleDown {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Animaciones después de la animación de entrada */
        .floating-btn.bounce {
            animation: bounce 1s infinite;
        }

        .floating-btn.pulse {
            animation: pulse 1s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

/* Aplicar márgenes para móviles */
@media (max-width: 768px) {
    .floating-btn {
        bottom: <?php echo esc_attr($mobile_margin_bottom); ?>;
        right: 20px; /* Asegura que el botón se mantenga a la derecha en móviles */
    }

    .floating-icons {
        bottom: calc(<?php echo esc_attr($mobile_margin_bottom); ?> + 70px); /* Alinea los iconos debajo del botón en dispositivos móviles */
        right: 20px; /* Asegura que los iconos también estén a la derecha */
    }
}

/* Aplicar márgenes para escritorio */
@media (min-width: 769px) {
    .floating-btn {
        bottom: <?php echo esc_attr($desktop_margin_bottom); ?>;
        right: 20px; /* Asegura que el botón se mantenga a la derecha en escritorio */
    }

    .floating-icons {
        bottom: calc(<?php echo esc_attr($desktop_margin_bottom); ?> + 70px); /* Alinea los iconos debajo del botón */
        right: 20px; /* Asegura que los iconos también estén a la derecha */
    }
}

.floating-icons button {
    color: white;
    border: none;
    border-radius: 50%;
    padding: 10px;
    font-size: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: transform 0.3s, background-color 0.3s;
    width: 50px;
    height: 50px;
}

.floating-icons button:hover {
    transform: scale(1.3);
}

        /* Estilos específicos de color para cada icono */
        .phone-btn { background-color: #25D366; } /* WhatsApp */
        .email-btn { background-color: #007bff; } /* Correo */
        .location-btn { background-color: #f44336; } /* Ubicación */
        .whatsapp-btn { background-color: #25D366; } /* WhatsApp */
        .facebook-btn { background-color: #3b5998; } /* Facebook */
        .instagram-btn { background-color: #e4405f; } /* Instagram */
        .tiktok-btn { background-color: #000000; } /* TikTok */
        .messenger-btn { background-color: #0084ff; } /* Messenger */
        .telegram-btn { background-color: #0088cc; } /* Telegram */
    </style>

    <!-- Botón flotante principal -->
    <button class="floating-btn <?php echo esc_attr($post_animation); ?>" id="mainBtn">
        <i class="fas fa-comment"></i>
    </button>

    <!-- Contenedor de iconos flotantes -->
    <div class="floating-icons" id="floatingIcons">
        <?php if ($whatsapp_link) : ?>
            <a href="https://wa.me/52<?php echo esc_attr($whatsapp_link); ?>" target="_blank">
                <button class="whatsapp-btn"><i class="fab fa-whatsapp"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($facebook_link) : ?>
            <a href="<?php echo esc_url($facebook_link); ?>" target="_blank">
                <button class="facebook-btn"><i class="fab fa-facebook"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($instagram_link) : ?>
            <a href="<?php echo esc_url($instagram_link); ?>" target="_blank">
                <button class="instagram-btn"><i class="fab fa-instagram"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($call_link) : ?>
            <a href="tel:<?php echo esc_attr($call_link); ?>" target="_blank">
                <button class="phone-btn"><i class="fas fa-phone-alt"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($email_link) : ?>
            <a href="mailto:<?php echo esc_attr($email_link); ?>" target="_blank">
                <button class="email-btn"><i class="fas fa-envelope"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($location_link) : ?>
            <a href="<?php echo esc_url($location_link); ?>" target="_blank">
                <button class="location-btn"><i class="fas fa-map-marker-alt"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($tiktok_link) : ?>
            <a href="<?php echo esc_url($tiktok_link); ?>" target="_blank">
                <button class="tiktok-btn"><i class="fab fa-tiktok"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($messenger_link) : ?>
            <a href="<?php echo esc_url($messenger_link); ?>" target="_blank">
                <button class="messenger-btn"><i class="fab fa-facebook-messenger"></i></button>
            </a>
        <?php endif; ?>
        <?php if ($telegram_link) : ?>
            <a href="<?php echo esc_url($telegram_link); ?>" target="_blank">
                <button class="telegram-btn"><i class="fab fa-telegram"></i></button>
            </a>
        <?php endif; ?>
    </div>

    <!-- Cargar FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        // Mostrar los iconos al hacer clic en el botón principal
        document.getElementById('mainBtn').addEventListener('click', function() {
            var floatingIcons = document.getElementById('floatingIcons');
            floatingIcons.classList.toggle('show');  // Cambia entre mostrar y ocultar
            // Detener animación al hacer clic
            this.classList.remove('bounce', 'pulse'); // Eliminar animaciones de rebote o pulsar
        });
    </script>
    <?php
}

// Hook para insertar el botón en el pie de página
add_action('wp_footer', 'fbw_add_floating_button');

// Agregar menú en el panel de administración
function fbw_add_admin_menu() {
    add_menu_page('Configurar botn de contacto', 'Boton de contacto', 'manage_options', 'contacto_boton', 'fbw_settings_page', 'dashicons-format-chat',5);
}

// Crear la página de configuración
function fbw_settings_page() {
    ?>
    <div class="wrap">
        <h1>Configuración del Botón Flotante</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('fbw_settings_group');
            do_settings_sections('floating_button');
            ?>
            <div class="form-table" style="display: flex; justify-content: space-between;">
                <div>
                    <h2>Enlaces</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enlace de WhatsApp</th>
                            <td><input type="txt" name="whatsapp_link" value="<?php echo esc_attr(get_option('whatsapp_link')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de WhatsApp</th>
                            <td><em>Ejemplo: <code>1234567890</code></em></td>
                        </tr>
                        <tr>
                            <th scope="row">Enlace de Facebook</th>
                            <td><input type="url" name="facebook_link" value="<?php echo esc_attr(get_option('facebook_link')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Facebook</th>
                            <td><em>Ejemplo: <code>https://facebook.com/tu-pagina</code></em></td>
                        </tr>
                        <tr>
                            <th scope="row">Enlace de Instagram</th>
                            <td><input type="url" name="instagram_link" value="<?php echo esc_attr(get_option('instagram_link')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Instagram</th>
                            <td><em>Ejemplo: <code>https://instagram.com/tu-perfil</code></em></td>
                        </tr>
                        <tr>
                            <th scope="row">Enlace de Llamada</th>
                            <td><input type="txt" name="call_link" value="<?php echo esc_attr(get_option('call_link')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Llamada</th>
                            <td><em>Ejemplo: <code>1234567890</code></em></td>
                        </tr>
                        <tr>
                            <th scope="row">Enlace de Correo</th>
                            <td><input type="email" name="email_link" value="<?php echo esc_attr(get_option('email_link')); ?>" /></td>
                        </tr>
						<tr>
                            <th scope="row">Ejemplo de Correo</th>
                            <td><em>Ejemplo: <code>correo@dominio.com<code></em></td>
                        </tr>
												<tr>
							<th scope="row">Enlace de Maps</th>
							<td><input type="url" name="location_link" value="<?php echo esc_attr(get_option('location_link')); ?>" class="regular-text" /></td>
						</tr>
						<tr>
                            <th scope="row">Ejemplo de Maps</th>
                            <td><em>Ejemplo: <code>https://maps.app.goo.gl/codigo-de-maps<code></em></td>
                        </tr>
						<tr>
							<th scope="row">Enlace de TikTok</th>
							<td><input type="url" name="tiktok_link" value="<?php echo esc_attr(get_option('tiktok_link')); ?>" class="regular-text" /></td>
						</tr>
						<tr>
                            <th scope="row">Ejemplo de Tik Tok</th>
                            <td><em>Ejemplo: <code>https://tiktok.com/@tu-usuario/<code></em></td>
                        </tr>
						<tr>
							<th scope="row">Enlace de Messenger</th>
							<td><input type="url" name="messenger_link" value="<?php echo esc_attr(get_option('messenger_link')); ?>" class="regular-text" /></td>
						</tr>
						<tr>
                            <th scope="row">Ejemplo de Messenger</th>
                            <td><em>Ejemplo: <code>https://m.me/tu-pagina<code></em></td>
                        </tr>
						<tr>
							<th scope="row">Enlace de Telegram</th>
							<td><input type="url" name="telegram_link" value="<?php echo esc_attr(get_option('telegram_link')); ?>" class="regular-text" /></td>
						</tr>
						<tr>
                            <th scope="row">Ejemplo de Telegram</th>
                            <td><em>Ejemplo: <code>https://t.me/tu-canal<code></em></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h2>Personalización</h2>
                    <table class="form-table">
                        <!-- Animación del botón -->
                        <tr>
                            <th scope="row">Animación del Botón</th>
                            <td>
                                <select name="button_animation">
                                    <option value="slide-up" <?php selected(get_option('button_animation'), 'slide-up'); ?>>Deslizar</option>
                                    <option value="scale-down" <?php selected(get_option('button_animation'), 'scale-down'); ?>>Emergente</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Animación Post-Entrada -->
                        <tr>
                            <th scope="row">Animación Post-Entrada</th>
                            <td>
                                <select name="post_animation">
                                    <option value="bounce" <?php selected(get_option('post_animation'), 'bounce'); ?>>Rebote</option>
                                    <option value="pulse" <?php selected(get_option('post_animation'), 'pulse'); ?>>Pulsar</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        <!-- Márgenes -->
                        <tr>
                            <th scope="row">Margen Inferior (Mobile)</th>
                            <td><input type="text" name="mobile_margin_bottom" value="<?php echo esc_attr(get_option('mobile_margin_bottom', '60px')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Margen Inferior (Mobile)</th>
                            <td><em>Ejemplo: <code>60px</code></em></td>
                        </tr>

                        <tr>
                            <th scope="row">Margen Lateral (Mobile)</th>
                            <td><input type="text" name="mobile_margin_left_right" value="<?php echo esc_attr(get_option('mobile_margin_left_right', '25px')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Margen Lateral (Mobile)</th>
                            <td><em>Ejemplo: <code>25px</code></em></td>
                        </tr>

                        <tr>
                            <th scope="row">Margen Inferior (Escritorio)</th>
                            <td><input type="text" name="desktop_margin_bottom" value="<?php echo esc_attr(get_option('desktop_margin_bottom', '60px')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Margen Inferior (Escritorio)</th>
                            <td><em>Ejemplo: <code>60px</code></em></td>
                        </tr>

                        <tr>
                            <th scope="row">Margen Lateral (Escritorio)</th>
                            <td><input type="text" name="desktop_margin_left_right" value="<?php echo esc_attr(get_option('desktop_margin_left_right', '60px')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Ejemplo de Margen Lateral (Escritorio)</th>
                            <td><em>Ejemplo: <code>60px</code></em></td>
                        </tr>

                        <!-- Colores del botón -->
                        <tr>
                            <th scope="row">Color del Botón</th>
                            <td><input type="color" name="button_color" value="<?php echo esc_attr(get_option('button_color', '#00bbff')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Color del Icono</th>
                            <td><input type="color" name="icon_color" value="<?php echo esc_attr(get_option('icon_color', '#ffffff')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Color Hover del Botón</th>
                            <td><input type="color" name="button_hover_color" value="<?php echo esc_attr(get_option('button_hover_color', '#009fd9')); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Color Hover del Icono</th>
                            <td><input type="color" name="icon_hover_color" value="<?php echo esc_attr(get_option('icon_hover_color', '#bfbfbf')); ?>" /></td>
                        </tr>
                    </table>
                </div>
            </div>
            <p class="submit"><input type="submit" value="Guardar Cambios" class="button-primary" /></p>
        </form>
    </div>
    <?php
}

// Registrar las configuraciones
function fbw_register_settings() {
    // Agregar configuraciones de enlaces y personalización
    register_setting('fbw_settings_group', 'whatsapp_link');
    register_setting('fbw_settings_group', 'facebook_link');
    register_setting('fbw_settings_group', 'instagram_link');
    register_setting('fbw_settings_group', 'call_link');
    register_setting('fbw_settings_group', 'email_link');
    register_setting('fbw_settings_group', 'location_link');
    register_setting('fbw_settings_group', 'tiktok_link');
    register_setting('fbw_settings_group', 'messenger_link');
    register_setting('fbw_settings_group', 'telegram_link');
    register_setting('fbw_settings_group', 'mobile_margin_bottom');
    register_setting('fbw_settings_group', 'mobile_margin_left_right');
    register_setting('fbw_settings_group', 'desktop_margin_bottom');
    register_setting('fbw_settings_group', 'desktop_margin_left_right');
    register_setting('fbw_settings_group', 'button_color');
    register_setting('fbw_settings_group', 'icon_color');
    register_setting('fbw_settings_group', 'button_hover_color');
    register_setting('fbw_settings_group', 'icon_hover_color');
    register_setting('fbw_settings_group', 'button_animation');
    register_setting('fbw_settings_group', 'post_animation');
}

add_action('admin_init', 'fbw_register_settings');
add_action('admin_menu', 'fbw_add_admin_menu');
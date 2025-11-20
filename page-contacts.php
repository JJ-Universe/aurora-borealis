<?php
/*
Template Name: Contacts Page
*/
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$contact_status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>

  <section class="section">
    <div class="container-inner">
      <?php if ( 'success' === $contact_status ) : ?>
        <div class="notice success" role="status"><?php esc_html_e( 'Thank you — your message was sent.', 'aurora-borealis' ); ?></div>
      <?php elseif ( 'error' === $contact_status ) : ?>
        <div class="notice error" role="alert"><?php esc_html_e( 'There was a problem with your submission. Please try again.', 'aurora-borealis' ); ?></div>
      <?php endif; ?>

      <h1><?php esc_html_e( 'Contact Us', 'aurora-borealis' ); ?></h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

      <div class="contact-grid" style="display:flex;gap:24px;flex-wrap:wrap">
        <div class="contact-info" style="flex:1 1 320px;min-width:260px">
          <h3><?php esc_html_e( 'Get in touch', 'aurora-borealis' ); ?></h3>
          <p><?php esc_html_e( 'Email', 'aurora-borealis' ); ?>: <a href="mailto:<?php echo esc_attr( antispambot( get_option( 'admin_email' ) ) ); ?>"><?php echo esc_html( antispambot( get_option( 'admin_email' ) ) ); ?></a></p>
          <p><?php esc_html_e( 'Address', 'aurora-borealis' ); ?>: Lorem ipsum dolor sit amet, 12345</p>
          <p><?php esc_html_e( 'Phone', 'aurora-borealis' ); ?>: (555) 555-5555</p>
        </div>

        <div class="contact-form" style="flex:1 1 420px;min-width:300px">
          <form id="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <?php wp_nonce_field( 'aurora_contact_nonce', 'aurora_contact_nonce_field' ); ?>
            <input type="hidden" name="action" value="aurora_contact_submit" />
            <input type="hidden" name="aurora_form_time" value="<?php echo esc_attr( time() ); ?>" />
            <div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true" tabindex="-1">
              <label for="aurora_hp">Leave this field empty</label>
              <input type="text" id="aurora_hp" name="aurora_hp" autocomplete="off" value="" />
            </div>

            <p><label><?php esc_html_e( 'Name', 'aurora-borealis' ); ?><br>
              <input type="text" name="aurora_name" required style="width:100%;padding:.5rem;border-radius:6px;border:1px solid rgba(0,0,0,0.08)" />
            </label></p>

            <p><label><?php esc_html_e( 'Email', 'aurora-borealis' ); ?><br>
              <input type="email" name="aurora_email" required style="width:100%;padding:.5rem;border-radius:6px;border:1px solid rgba(0,0,0,0.08)" />
            </label></p>

            <p><label><?php esc_html_e( 'Subject', 'aurora-borealis' ); ?><br>
              <input type="text" name="aurora_subject" required style="width:100%;padding:.5rem;border-radius:6px;border:1px solid rgba(0,0,0,0.08)" />
            </label></p>

            <p><label><?php esc_html_e( 'Message', 'aurora-borealis' ); ?><br>
              <textarea name="aurora_message" rows="6" required style="width:100%;padding:.5rem;border-radius:6px;border:1px solid rgba(0,0,0,0.08)"></textarea>
            </label></p>

            <p><button type="submit" class="btn-outline"><?php esc_html_e( 'Send message', 'aurora-borealis' ); ?></button></p>
          </form>
        </div>
      </div>

    </div>
  </section>

<?php
get_footer();

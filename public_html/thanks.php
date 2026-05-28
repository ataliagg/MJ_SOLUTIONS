<?php
// Página de confirmación luego de enviar el formulario.
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Thank You | MJ Cleaning Solutions</title>
  <link rel="stylesheet" href="./paginatia3.css" />
  <script src="./menu.js" defer></script>
</head>

<body>
  <header class="site-header">
    <div class="container nav">
      <a class="brand" href="./index.html">
        <img class="brand-logo" src="https://static.wixstatic.com/media/03bc3e_f6dd0edf3c0d4c7794ade197c32ad70e~mv2.png/v1/crop/x_0%2Cy_3%2Cw_561%2Ch_807/fill/w_239%2Ch_344%2Cal_c%2Cq_85%2Cusm_0.66_1.00_0.01%2Cenc_avif%2Cquality_auto/_edited.png" alt="MJ Cleaning Solutions logo" />
        <span class="brand-name">MJ Cleaning Solutions</span>
      </a>

      <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="nav-links" aria-label="Primary navigation">
        <a href="./index.html">Home</a>

        <div class="dropdown">
          <button class="dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
            Markets
            <span class="dropdown-caret" aria-hidden="true">▾</span>
          </button>
          <div class="dropdown-menu" role="menu" aria-label="Markets">
            <a href="./markets.html#education" role="menuitem">Education Facilities</a>
            <a href="./markets.html#healthcare" role="menuitem">Healthcare Facilities</a>
            <a href="./markets.html#industrial" role="menuitem">Industrial Cleaning</a>
            <a href="./markets.html#city" role="menuitem">Public Sector</a>
          </div>
        </div>

      <div class="dropdown">
        <button class="dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
          Services
            <span class="dropdown-caret" aria-hidden="true">▾</span>
          </button>
          <div class="dropdown-menu" role="menu" aria-label="Services">
            <a href="./services.html#post-construction" role="menuitem">Post Construction Cleaning</a>
            <a href="./services.html#commercial" role="menuitem">Commercial Cleaning</a>
            <a href="./services.html#janitorial" role="menuitem">Janitorial Cleaning</a>
          </div>
      </div>

        <a href="./about.html">About Us</a>
        <a href="./meat-team.html">Meet Our Team</a>
        <a href="./our-work.html">Our Work</a>
        <a href="./contact.html">Contact</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-card">
          <div class="hero-copy">
            <div class="kicker">Message sent</div>
            <h1 class="h1">Thank you for reaching out.</h1>
            <p class="hero-sub">
              Your request has been received successfully. A member of MJ Cleaning Solutions will review your information and contact you soon with the next steps and a quote.
            </p>

            <div class="badge" style="margin-bottom: 1rem;">
              <span>✓</span>
              <span>We have your message</span>
            </div>

            <div class="btn-row">
              <a class="btn primary" href="./index.html">Back to Home</a>
              <a class="btn" href="./contact.html">Send Another Message</a>
              <a class="btn" href="mailto:MJG@mjcleaningsolution.com">Email Us Directly</a>
            </div>
          </div>
        </div>

        <div class="hero-card hero-media">
          <img src="./assets/hero-2.jpg" alt="MJ Cleaning Solutions team" />
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container contact-grid">
        <div class="panel pad">
          <div class="section-head">
            <div class="kicker">What happens next</div>
            <h2 class="h2">We’ll take it from here.</h2>
            <p class="lede">
              We’ll review the details you sent, check the scope of work, and get back to you as soon as possible.
            </p>
          </div>

          <div class="hr"></div>

          <ul class="clean-list">
            <li>We read your message and review the requested service.</li>
            <li>We contact you using the email or phone number you provided.</li>
            <li>If needed, we ask a couple of quick follow-up questions.</li>
          </ul>
        </div>

        <div class="panel pad">
          <div class="section-head">
            <div class="kicker">Direct contact</div>
            <h2 class="h2">Need something faster?</h2>
            <p class="lede">
              You can reach us directly at the email below or send another request from the contact page.
            </p>
          </div>

          <div class="hr"></div>

          <p><strong>Email:</strong> <a href="mailto:MJG@mjcleaningsolution.com">MJG@mjcleaningsolution.com</a></p>
          <p><strong>Phone:</strong> (571) 572-4720</p>
          <p><strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 6:00 PM</p>

          <div class="hr"></div>

          <a class="btn primary" href="tel:+15715724720">Call Now</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <div class="badge">MJ Cleaning Solutions • Est. 2012</div>
        <p style="margin-top:.8rem" class="note">
          Professional cleaning for residential, commercial, and specialty needs.
          Serving Virginia and the DC area.
        </p>
        <p class="note" style="margin-top:.7rem">
          © <span id="year"></span> MJ Cleaning Solutions. All rights reserved.
        </p>
      </div>

      <div class="footer-links" aria-label="Footer links">
        <a href="./markets.html">Markets</a>
        <a href="./services.html">Services</a>
        <a href="./our-work.html">Our Work</a>
        <a href="./contact.html">Contact</a>
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --bg: #0a0a0f;
        --surface: #12121a;
        --yellow: #f5e642;
        --cyan: #00f0ff;
        --white: #e8e8ff;
        --muted: #4a4a6a;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: var(--bg);
        color: var(--white);
        font-family: "Rajdhani", sans-serif;
        font-weight: 500;
        line-height: 1.6;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    body::after {
        content: "";
        position: fixed;
        inset: 0;
        background: repeating-linear-gradient(
            0deg,
            rgba(0, 0, 0, 0.18) 0px,
            rgba(0, 0, 0, 0.18) 1px,
            transparent 1px,
            transparent 2px
        );
        pointer-events: none;
        z-index: 9999;
    }

    ::selection {
        background: var(--yellow);
        color: #0a0a0f;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: #0a0a0f;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--yellow);
    }

    .cat-section {
        margin-bottom: 72px;
    }
    .cat-hdr {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(245, 230, 66, 0.1);
    }
    .cat-num {
        font-family: "Share Tech Mono", monospace;
        font-size: 9px;
        color: rgba(245, 230, 66, 0.22);
        letter-spacing: 0.25em;
        flex-shrink: 0;
    }
    .cat-mod {
        font-family: "Share Tech Mono", monospace;
        font-size: 9px;
        color: var(--yellow);
        text-transform: uppercase;
        letter-spacing: 0.25em;
        border-left: 2px solid rgba(245, 230, 66, 0.5);
        padding-left: 10px;
        text-shadow: 0 0 8px rgba(245, 230, 66, 0.35);
    }
    .cat-name {
        font-family: "Orbitron", monospace;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--muted);
        margin-left: auto;
    }

    .feat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: rgba(245, 230, 66, 0.08);
    }
    .fcs {
        background: var(--surface);
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: background 0.18s;
    }
    .fcs:hover {
        background: #16162a;
    }
    .fcs::before,
    .fcs::after {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        border-style: solid;
        border-color: transparent;
        transition: border-color 0.2s;
    }
    .fcs::before {
        top: 0;
        left: 0;
        border-width: 2px 0 0 2px;
    }
    .fcs::after {
        bottom: 0;
        right: 0;
        border-width: 0 2px 2px 0;
    }
    .fcs:hover::before,
    .fcs:hover::after {
        border-color: var(--yellow);
    }
    .fcs-icon {
        font-size: 14px;
        color: var(--cyan);
        margin-bottom: 12px;
        text-shadow: 0 0 8px rgba(0, 240, 255, 0.45);
        transition: all 0.2s;
    }
    .fcs:hover .fcs-icon {
        color: var(--yellow);
        text-shadow: 0 0 10px rgba(245, 230, 66, 0.6);
    }
    .fcs-title {
        font-family: "Orbitron", monospace;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--white);
        margin-bottom: 7px;
        line-height: 1.35;
    }
    .fcs-desc {
        font-family: "Share Tech Mono", monospace;
        font-size: 11px;
        color: rgba(232, 232, 255, 0.38);
        line-height: 1.6;
    }

    @media (max-width: 1100px) {
        .feat-grid-4 {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 760px) {
        .feat-grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 480px) {
        .feat-grid-4 {
            grid-template-columns: 1fr;
        }
    }

    .features {
        padding: 100px 24px;
        max-width: 1240px;
        margin: 0 auto;
    }

    .sec-label {
        font-family: "Share Tech Mono", monospace;
        font-size: 10px;
        color: var(--yellow);
        text-transform: uppercase;
        letter-spacing: 0.28em;
        border-left: 3px solid var(--yellow);
        padding-left: 12px;
        margin-bottom: 16px;
        display: block;
    }
    .sec-title {
        font-family: "Orbitron", monospace;
        font-weight: 700;
        font-size: clamp(26px, 4vw, 42px);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        line-height: 1.1;
        margin-bottom: 60px;
    }
</style>

<section class="features" id="features">
    <span class="sec-label">// Full System Module Index — 001–017</span>
    <h2 class="sec-title">Complete systems<br />checklist: all modules armed.</h2>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">01</span>
            <span class="cat-mod">MODULE::VISUAL</span>
            <span class="cat-name">Design &amp; Visual Style</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-moon"></i></div>
                <div class="fcs-title">Dark Aesthetic</div>
                <div class="fcs-desc">
                    Deep black backgrounds with neon yellow and cyan accents throughout every element.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-display"></i></div>
                <div class="fcs-title">Sci-Fi HUD Mode</div>
                <div class="fcs-desc">
                    Second full visual style: cyan palette, corner-bracket panels, reticle dot. Switch in Customizer —
                    no rebuild.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-font"></i></div>
                <div class="fcs-title">Custom Fonts</div>
                <div class="fcs-desc">
                    Orbitron headings, Rajdhani body (Share Tech Mono in HUD mode). Auto-loaded from Google Fonts.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-bolt"></i></div>
                <div class="fcs-title">Neon Glow Effects</div>
                <div class="fcs-desc">
                    Badges, buttons, and headings carry neon glow. Colour auto-assigned from category slug — zero
                    config.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tv"></i></div>
                <div class="fcs-title">CRT Scan-Line</div>
                <div class="fcs-desc">
                    Animated scan-line scrolls across the page like a vintage monitor. Toggleable off in Customizer.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tag"></i></div>
                <div class="fcs-title">Category Colour Badges</div>
                <div class="fcs-desc">
                    Each category auto-assigned cyan, magenta, green, or yellow from its slug — no manual setup.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-thumbtack"></i></div>
                <div class="fcs-title">Pinned Post Indicator</div>
                <div class="fcs-desc">
                    Sticky posts display a thumbtack icon and PINNED label so readers know they're featured.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-lock"></i></div>
                <div class="fcs-title">Protected Post Lock Screen</div>
                <div class="fcs-desc">
                    Password-protected posts show a styled cyberpunk lock screen instead of WordPress's plain default
                    form.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-scissors"></i></div>
                <div class="fcs-title">Clip-Path Shapes</div>
                <div class="fcs-desc">
                    Buttons and badges use angled corner cuts via clip-path for a sci-fi hardware aesthetic.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">02</span>
            <span class="cat-mod">MODULE::NAV</span>
            <span class="cat-name">Navigation</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-bars"></i></div>
                <div class="fcs-title">Responsive Mobile Menu</div>
                <div class="fcs-desc">Hamburger button opens a slide-down menu on phones and tablets.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-chevron-down"></i></div>
                <div class="fcs-title">Dropdown Sub-Menus</div>
                <div class="fcs-desc">
                    Hover top-level items on desktop to reveal sub-pages. Tap the arrow on mobile.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-keyboard"></i></div>
                <div class="fcs-title">Keyboard Navigation</div>
                <div class="fcs-desc">
                    Tab, Enter, Space, and Escape all work correctly for keyboard-only users throughout menus.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-arrow-up"></i></div>
                <div class="fcs-title">Sticky Header</div>
                <div class="fcs-desc">Nav bar darkens and locks to the top of the screen as you scroll down.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-angle-right"></i></div>
                <div class="fcs-title">Breadcrumb Trail</div>
                <div class="fcs-desc">Shows Home &gt; Category &gt; Post Title on every page for orientation.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-image"></i></div>
                <div class="fcs-title">Logo with Fallback</div>
                <div class="fcs-desc">
                    Displays uploaded logo, or falls back to the site name in styled text if none is set.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-ellipsis"></i></div>
                <div class="fcs-title">Footer Navigation</div>
                <div class="fcs-desc">
                    Two separate footer menu locations: one for site sections, one for system/policy links.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">03</span>
            <span class="cat-mod">MODULE::POSTS</span>
            <span class="cat-name">Posts &amp; Pages</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-star"></i></div>
                <div class="fcs-title">Featured Hero Post</div>
                <div class="fcs-desc">First post on homepage shown as a large full-width card to draw readers in.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-id-card"></i></div>
                <div class="fcs-title">Rich Post Cards</div>
                <div class="fcs-desc">
                    Cards show image, category badge, difficulty badge, title, author, date, reading time, word count,
                    comment count, excerpt, and tags.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div class="fcs-title">Single Post Layout</div>
                <div class="fcs-desc">
                    Long-form view with hero image, large title, author info, and reading progress bar.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-file"></i></div>
                <div class="fcs-title">Static Page Layout</div>
                <div class="fcs-desc">Clean full-width layout for About, Contact, and similar standalone pages.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-book-open"></i></div>
                <div class="fcs-title">Multi-Page Posts</div>
                <div class="fcs-desc">Long posts split across numbered pages with navigation links between them.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="fcs-title">Last Updated Notice</div>
                <div class="fcs-desc">
                    Badge shows the updated date when a post was significantly edited after publishing.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-eye"></i></div>
                <div class="fcs-title">View Counter</div>
                <div class="fcs-desc">
                    Tracks how many times each post has been viewed; count displayed in post meta.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-calculator"></i></div>
                <div class="fcs-title">Word Count Display</div>
                <div class="fcs-desc">Total word count shown alongside reading time estimate on every post.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="fcs-title">Difficulty Badge</div>
                <div class="fcs-desc">
                    Tag posts Beginner, Intermediate, or Advanced. Colour-coded badge (green/yellow/red) on cards and
                    single view.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-trophy"></i></div>
                <div class="fcs-title">Milestone View Badges</div>
                <div class="fcs-desc">
                    Posts crossing 100, 500, 1000, or 5000 views auto-earn HOT, TRENDING, VIRAL, or LEGENDARY badge.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="fcs-title">Post Age Notice</div>
                <div class="fcs-desc">
                    Articles older than two years show a warning banner that content may be outdated.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                <div class="fcs-title">Glitch Title Effect</div>
                <div class="fcs-desc">
                    Post titles briefly glitch-animate on hover for extra cyberpunk visual flavour.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <div class="fcs-title">Admin Edit Link</div>
                <div class="fcs-desc">Admins see a quick edit link on posts and pages while logged in to wp-admin.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-sitemap"></i></div>
                <div class="fcs-title">Related Posts</div>
                <div class="fcs-desc">
                    Three posts from the same category suggested automatically at the bottom of every article.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">04</span>
            <span class="cat-mod">MODULE::SERIES</span>
            <span class="cat-name">Post Series</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div class="fcs-title">Series Grouping</div>
                <div class="fcs-desc">
                    Assign posts to a named series (e.g. "Intro to Linux") to keep multi-part content connected.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-arrows-left-right"></i></div>
                <div class="fcs-title">Series Navigation Banner</div>
                <div class="fcs-desc">
                    Panel shows series name, current position, total estimated reading time, and prev/next links.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-list-check"></i></div>
                <div class="fcs-title">Collapsible Table of Contents</div>
                <div class="fcs-desc">
                    Lists every part in order inside the series banner. Already-read posts get automatic checkmarks.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-folder-open"></i></div>
                <div class="fcs-title">Series Archive Page</div>
                <div class="fcs-desc">
                    Every series gets its own archive page listing all posts in order, linked from the banner.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <div class="fcs-title">Series Progress Widget</div>
                <div class="fcs-desc">
                    Sidebar widget shows a progress bar and numbered checklist; already-visited parts are highlighted.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">05</span>
            <span class="cat-mod">MODULE::FORMATS</span>
            <span class="cat-name">Post Formats</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-newspaper"></i></div>
                <div class="fcs-title">Standard Posts</div>
                <div class="fcs-desc">Full card with featured image, excerpt, and a DECRYPT read-more button.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-quote-left"></i></div>
                <div class="fcs-title">Quote Posts</div>
                <div class="fcs-desc">
                    Large decorative quotation marks with the quote styled as a block on archive cards.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-video"></i></div>
                <div class="fcs-title">Video Posts</div>
                <div class="fcs-desc">
                    Thumbnail with a red play button overlay to signal the post contains a video.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-link"></i></div>
                <div class="fcs-title">Link Posts</div>
                <div class="fcs-desc">
                    Extracts the first external URL, shows the domain, and opens it in a new tab on click.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-note-sticky"></i></div>
                <div class="fcs-title">Aside / Note Posts</div>
                <div class="fcs-desc">
                    Compact note-style card without a featured image for short thoughts and observations.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">06</span>
            <span class="cat-mod">MODULE::ARCHIVE</span>
            <span class="cat-name">Archives &amp; Discovery</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-folder"></i></div>
                <div class="fcs-title">Category Archives</div>
                <div class="fcs-desc">Styled header, description, and total post count for every category.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tags"></i></div>
                <div class="fcs-title">Tag Archives</div>
                <div class="fcs-desc">Tag chip header with post count listing all posts carrying a given tag.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-user-tag"></i></div>
                <div class="fcs-title">Author Archives</div>
                <div class="fcs-desc">
                    Full author profile card (avatar, bio, social links) displayed above their posts.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-calendar"></i></div>
                <div class="fcs-title">Date Archives</div>
                <div class="fcs-desc">Browse posts by year or month with styled archive headers.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-hashtag"></i></div>
                <div class="fcs-title">Post Count Display</div>
                <div class="fcs-desc">Every archive header shows how many posts were found — e.g. "42 RECORDS".</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-ellipsis"></i></div>
                <div class="fcs-title">Smart Pagination</div>
                <div class="fcs-desc">
                    Numbered page links with previous/next arrows and ellipsis for large archives.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-stopwatch"></i></div>
                <div class="fcs-title">Reading Time Filter</div>
                <div class="fcs-desc">
                    Filter Short (≤5 min), Medium (6–15 min), or Long (15+ min) posts via clean URLs.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="fcs-title">Difficulty Filter</div>
                <div class="fcs-desc">
                    Filter Beginner, Intermediate, or Advanced posts using the same clean URL system.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-ban"></i></div>
                <div class="fcs-title">Filter Empty State</div>
                <div class="fcs-desc">
                    When a filter returns no posts, a helpful message is shown instead of a broken page.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">07</span>
            <span class="cat-mod">MODULE::SEARCH</span>
            <span class="cat-name">Search</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="fcs-title">Search Results Page</div>
                <div class="fcs-desc">Styled results page showing the query and how many results were found.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-highlighter"></i></div>
                <div class="fcs-title">Term Highlighting</div>
                <div class="fcs-desc">
                    Searched words are highlighted in yellow in every result excerpt automatically.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="fcs-title">Pretty Search URLs</div>
                <div class="fcs-desc">URLs look clean like /search/cyberpunk/ instead of ?s=cyberpunk.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="fcs-title">No Results State</div>
                <div class="fcs-desc">A styled message with a fresh search form appears when nothing is found.</div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">08</span>
            <span class="cat-mod">MODULE::INTERACTIVE</span>
            <span class="cat-name">Interactive Features</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div class="fcs-title">Reading Progress Bar</div>
                <div class="fcs-desc">Neon bar across the top of the page fills as you read through a post.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="fcs-title">Finish Time Estimate</div>
                <div class="fcs-desc">
                    Shows minutes left and the exact clock time you'll finish. Updates live as you scroll.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-percent"></i></div>
                <div class="fcs-title">Tab Title Progress</div>
                <div class="fcs-desc">
                    Browser tab title updates with your scroll percentage — useful when tab is in the background.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-list"></i></div>
                <div class="fcs-title">Auto Table of Contents</div>
                <div class="fcs-desc">
                    Collapsible panel on posts with 3+ headings. Current section highlights as you scroll.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-expand"></i></div>
                <div class="fcs-title">Image Lightbox</div>
                <div class="fcs-desc">
                    Click any post image to open full-screen. Arrow key and button navigation supported.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-copy"></i></div>
                <div class="fcs-title">Code Copy Button</div>
                <div class="fcs-desc">
                    Hover any code block for one-click copy. Shows language label and checkmark on confirmation.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-code"></i></div>
                <div class="fcs-title">Syntax Highlighting</div>
                <div class="fcs-desc">
                    Code blocks colour-coded by language. Keywords, strings, comments, functions each styled distinctly.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-eye"></i></div>
                <div class="fcs-title">Scroll Reveal Animations</div>
                <div class="fcs-desc">
                    Post cards fade in as they scroll into view. Skipped automatically for reduced-motion users.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-arrow-up"></i></div>
                <div class="fcs-title">Back-to-Top Button</div>
                <div class="fcs-desc">
                    Fixed button appears after scrolling down, returning you instantly to the top of the page.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-keyboard"></i></div>
                <div class="fcs-title">Archive Keyboard Shortcuts</div>
                <div class="fcs-desc">
                    Press j/k to move between posts, o to open, ? to see all shortcuts. No mouse needed.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-terminal"></i></div>
                <div class="fcs-title">Command Palette</div>
                <div class="fcs-desc">
                    Ctrl+K / Cmd+K to instantly search posts and jump to navigation links without the mouse.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-bullhorn"></i></div>
                <div class="fcs-title">Announcement Bar</div>
                <div class="fcs-desc">
                    Dismissible banner above nav for important messages. Info, warning, or alert styling.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-bookmark"></i></div>
                <div class="fcs-title">Reading Queue</div>
                <div class="fcs-desc">
                    Bookmark button on every post saves articles to a personal browser-stored reading queue.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                <div class="fcs-title">Reading List Page</div>
                <div class="fcs-desc">
                    Page template displays the visitor's saved queue with thumbnails, titles, and remove button.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-chart-bar"></i></div>
                <div class="fcs-title">Reading Stats Page</div>
                <div class="fcs-desc">
                    Template shows total posts read, reactions given, and posts currently queued per visitor.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-fire-flame-curved"></i></div>
                <div class="fcs-title">Post Reactions</div>
                <div class="fcs-desc">
                    FIRE, HYPE, INTEL, or CORRUPT reactions. Server-side counts, one vote per visitor per post.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-circle-check"></i></div>
                <div class="fcs-title">Read Tracker</div>
                <div class="fcs-desc">
                    Posts you've read get a cyan READ badge on archive pages. History saved in the browser.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-share-nodes"></i></div>
                <div class="fcs-title">Share Buttons</div>
                <div class="fcs-desc">X/Twitter, Mastodon, Telegram, and a copy-link button on every post.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-text-height"></i></div>
                <div class="fcs-title">Font Size Toggle</div>
                <div class="fcs-desc">
                    S / M / L buttons in the post footer. Choice persisted in the browser across visits.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-anchor"></i></div>
                <div class="fcs-title">Anchor Link Copy</div>
                <div class="fcs-desc">
                    Hover any H2/H3/H4 to reveal a link icon. Clicking copies the direct anchor URL.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-floppy-disk"></i></div>
                <div class="fcs-title">Auto-Save Draft Comments</div>
                <div class="fcs-desc">
                    Comment drafts saved in the browser and restored automatically if you navigate away.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-history"></i></div>
                <div class="fcs-title">Recently Viewed Tracking</div>
                <div class="fcs-desc">
                    Every post you read is silently saved to local browser history for the Recently Viewed widget.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">09</span>
            <span class="cat-mod">MODULE::SHORTCODES</span>
            <span class="cat-name">Shortcodes</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-terminal"></i></div>
                <div class="fcs-title">Code Block</div>
                <div class="fcs-desc">
                    [codeblock lang="php"] — terminal-style block with language label and copy button.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-circle-info"></i></div>
                <div class="fcs-title">Callout Box</div>
                <div class="fcs-desc">
                    [callout type="info/warning/danger/tip"] — styled alert with icon and colour-coded border.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-eye-slash"></i></div>
                <div class="fcs-title">Spoiler</div>
                <div class="fcs-desc">
                    [spoiler] — hides content behind a blur that the reader reveals with a click.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-superscript"></i></div>
                <div class="fcs-title">Inline Footnotes</div>
                <div class="fcs-desc">
                    [fn] — numbered footnote. All collected and printed as a linked list at the article end.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-quote-right"></i></div>
                <div class="fcs-title">Pull Quote</div>
                <div class="fcs-desc">
                    [pullquote] — floats a styled pull quote right or left of the post body; full-width on mobile.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-code-branch"></i></div>
                <div class="fcs-title">Diff Block</div>
                <div class="fcs-desc">
                    [diff lang="php"] — colour-coded diff view: green added, red removed, cyan hunk headers.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-keyboard"></i></div>
                <div class="fcs-title">Keyboard Badges</div>
                <div class="fcs-desc">
                    [kbd]Ctrl+K[/kbd] — renders keycap badges, auto-splitting on + to wrap each key.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-scroll"></i></div>
                <div class="fcs-title">Changelog</div>
                <div class="fcs-desc">
                    [changelog][version num="" date=""] — versioned history block with collapsible entries per release.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">10</span>
            <span class="cat-mod">MODULE::WIDGETS</span>
            <span class="cat-name">Sidebar &amp; Widgets</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="fcs-title">Search Widget</div>
                <div class="fcs-desc">Styled search box with custom label and status badge.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-newspaper"></i></div>
                <div class="fcs-title">Recent Posts Widget</div>
                <div class="fcs-desc">Latest posts with thumbnail, category badge, title, and date.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-folder"></i></div>
                <div class="fcs-title">Categories Widget</div>
                <div class="fcs-desc">All categories with colour-coded icon and post count.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tags"></i></div>
                <div class="fcs-title">Tag Cloud Widget</div>
                <div class="fcs-desc">Tags displayed at different sizes based on how many posts carry them.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-box-archive"></i></div>
                <div class="fcs-title">Archive Widget</div>
                <div class="fcs-desc">Post history grouped by year, with each year collapsing to show its months.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-fire"></i></div>
                <div class="fcs-title">Most Viewed Widget</div>
                <div class="fcs-desc">Top posts ranked by view count. Configurable number of results to display.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <div class="fcs-title">Recently Viewed Widget</div>
                <div class="fcs-desc">
                    Visitor's personal reading history — up to six posts with thumbnails and reading times.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-comment"></i></div>
                <div class="fcs-title">Recently Commented Widget</div>
                <div class="fcs-desc">
                    Posts with most recent approved comments, deduplicated so each post appears once.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <div class="fcs-title">Series Progress Widget</div>
                <div class="fcs-desc">
                    Progress bar and numbered checklist for series posts; visited parts highlighted automatically.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-thumbtack"></i></div>
                <div class="fcs-title">Sticky Sidebar</div>
                <div class="fcs-desc">Sidebar stays visible as you scroll through long posts — always in reach.</div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">11</span>
            <span class="cat-mod">MODULE::CUSTOMISER</span>
            <span class="cat-name">Customiser Settings</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-palette"></i></div>
                <div class="fcs-title">Visual Style Selector</div>
                <div class="fcs-desc">
                    Switch entire theme between Cyberpunk and Sci-Fi HUD from Appearance &gt; Customize. No rebuild.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-share-nodes"></i></div>
                <div class="fcs-title">Social Link Icons</div>
                <div class="fcs-desc">
                    Enter X/Twitter, Mastodon, and Telegram URLs; icons appear in the footer automatically.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-bullhorn"></i></div>
                <div class="fcs-title">Announcement Bar Config</div>
                <div class="fcs-desc">
                    Turn on site-wide banner, set message, and choose info (cyan), warning (yellow), or alert (red)
                    styling.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tv"></i></div>
                <div class="fcs-title">CRT Scanline Toggle</div>
                <div class="fcs-desc">Turn the animated scan-line effect on or off without touching any code.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-signal"></i></div>
                <div class="fcs-title">Status Strip Text</div>
                <div class="fcs-desc">Customise the status label and tagline shown in the bar beneath navigation.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-heading"></i></div>
                <div class="fcs-title">Index Page Heading</div>
                <div class="fcs-desc">Change what the main blog page title says. Default: INCOMING TRANSMISSIONS.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-building"></i></div>
                <div class="fcs-title">Footer Brand Text</div>
                <div class="fcs-desc">Set your footer tagline and a short site description shown in the footer.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-copyright"></i></div>
                <div class="fcs-title">Copyright Text</div>
                <div class="fcs-desc">
                    Enter custom copyright text or leave blank for an auto-generated one with the current year.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">12</span>
            <span class="cat-mod">MODULE::ADMIN</span>
            <span class="cat-name">Admin Tools</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-eye"></i></div>
                <div class="fcs-title">Admin Bar View Count</div>
                <div class="fcs-desc">
                    When a logged-in admin or editor views any single post, the live view count appears in the WP admin
                    bar.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">13</span>
            <span class="cat-mod">MODULE::AUTHORS</span>
            <span class="cat-name">Author Profiles</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-user"></i></div>
                <div class="fcs-title">Author Bio Box</div>
                <div class="fcs-desc">
                    Below every article: avatar, name, handle, bio, and social links in a styled panel.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-at"></i></div>
                <div class="fcs-title">Custom Handle Field</div>
                <div class="fcs-desc">
                    Authors set a handle (e.g. @username) that appears in their bio card on every post.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-share-nodes"></i></div>
                <div class="fcs-title">Author Social Links</div>
                <div class="fcs-desc">
                    Each author can add X/Twitter, Mastodon, and Telegram links from their wp-admin profile page.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-address-card"></i></div>
                <div class="fcs-title">Author Archive with Profile</div>
                <div class="fcs-desc">
                    Visiting an author's archive shows their full profile card above their post listing.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">14</span>
            <span class="cat-mod">MODULE::COMMENTS</span>
            <span class="cat-name">Comments</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-comments"></i></div>
                <div class="fcs-title">Styled Comment Section</div>
                <div class="fcs-desc">
                    Comments use the theme's HUD aesthetic with a "TRANSMISSIONS RECEIVED" heading.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-shield"></i></div>
                <div class="fcs-title">Moderator Badge</div>
                <div class="fcs-desc">
                    Comments from moderators display a [MOD] label so readers can identify site staff.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-reply-all"></i></div>
                <div class="fcs-title">Threaded Comments</div>
                <div class="fcs-desc">Replies visually indented and colour-differentiated by nesting depth.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                <div class="fcs-title">Pending Moderation Notice</div>
                <div class="fcs-desc">
                    Comments awaiting approval show "TRANSMISSION PENDING CLEARANCE" instead of nothing.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-ban"></i></div>
                <div class="fcs-title">Comments Closed Notice</div>
                <div class="fcs-desc">
                    "TRANSMISSION CHANNEL CLOSED" message appears instead of a broken or missing form.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-circle-user"></i></div>
                <div class="fcs-title">Initials Fallback Avatar</div>
                <div class="fcs-desc">
                    No Gravatar? The author's initials appear in a styled avatar box instead of a blank image.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-pen"></i></div>
                <div class="fcs-title">Themed Comment Form</div>
                <div class="fcs-desc">
                    Fields use cyberpunk-flavoured labels — e.g. OPERATIVE_ID for the name field.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">15</span>
            <span class="cat-mod">MODULE::MEDIA</span>
            <span class="cat-name">Media &amp; Attachments</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-image"></i></div>
                <div class="fcs-title">Image Attachment Pages</div>
                <div class="fcs-desc">Direct image links show the full-size photo in a clean, themed layout.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-camera"></i></div>
                <div class="fcs-title">EXIF Data Display</div>
                <div class="fcs-desc">
                    Camera, aperture, focal length, ISO, and shutter speed shown when the image contains them.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-download"></i></div>
                <div class="fcs-title">File Download Pages</div>
                <div class="fcs-desc">Non-image attachments show the filename and a styled download button.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-arrow-left"></i></div>
                <div class="fcs-title">Return to Post Link</div>
                <div class="fcs-desc">Attachment pages link back to the parent post they belong to.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-grip"></i></div>
                <div class="fcs-title">Custom Gallery Grid</div>
                <div class="fcs-desc">
                    [gallery] shortcode outputs a styled grid with an expand overlay on each image.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-film"></i></div>
                <div class="fcs-title">Video Embed Wrapper</div>
                <div class="fcs-desc">YouTube and other embeds get a HUD-style header bar wrapping the player.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-table"></i></div>
                <div class="fcs-title">Responsive Tables</div>
                <div class="fcs-desc">
                    Tables in post content scroll horizontally on small screens instead of breaking the layout.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">16</span>
            <span class="cat-mod">MODULE::SEO</span>
            <span class="cat-name">SEO &amp; Metadata</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-brands fa-facebook"></i></div>
                <div class="fcs-title">Open Graph Tags</div>
                <div class="fcs-desc">
                    Posts share correctly on Facebook, LinkedIn, and other platforms with title, description, and image.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-brands fa-x-twitter"></i></div>
                <div class="fcs-title">Twitter / X Cards</div>
                <div class="fcs-desc">Posts show a large image preview card when shared on X/Twitter.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-code"></i></div>
                <div class="fcs-title">Structured Data (JSON-LD)</div>
                <div class="fcs-desc">
                    Article, WebSite SearchAction, and BreadcrumbList schema for Google rich results.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-link"></i></div>
                <div class="fcs-title">Canonical URLs</div>
                <div class="fcs-desc">
                    Every page has a canonical link to prevent duplicate content issues with search engines.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-eye-slash"></i></div>
                <div class="fcs-title">Noindex on Search &amp; 404</div>
                <div class="fcs-desc">
                    Search results and 404 pages are automatically excluded from search engine indexing.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-handshake"></i></div>
                <div class="fcs-title">SEO Plugin Compatible</div>
                <div class="fcs-desc">
                    When Yoast, RankMath, AIOSEO, or The SEO Framework is active, the theme steps aside to avoid
                    duplicates.
                </div>
            </div>
        </div>
    </div>

    <div class="cat-section">
        <div class="cat-hdr">
            <span class="cat-num">17</span>
            <span class="cat-mod">MODULE::A11Y</span>
            <span class="cat-name">Accessibility</span>
        </div>
        <div class="feat-grid-4">
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-forward"></i></div>
                <div class="fcs-title">Skip to Content Link</div>
                <div class="fcs-desc">Keyboard users bypass the navigation and jump straight to main content.</div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-landmark"></i></div>
                <div class="fcs-title">Semantic HTML Landmarks</div>
                <div class="fcs-desc">
                    Screen readers navigate by header, nav, main, sidebar, and footer regions throughout.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-crosshairs"></i></div>
                <div class="fcs-title">Visible Focus Styles</div>
                <div class="fcs-desc">
                    Every interactive element shows a clear highlight when navigated by keyboard.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-person-walking"></i></div>
                <div class="fcs-title">Reduced Motion Support</div>
                <div class="fcs-desc">
                    All animations disabled automatically when the visitor's OS prefers reduced motion.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-tag"></i></div>
                <div class="fcs-title">ARIA Labels Throughout</div>
                <div class="fcs-desc">
                    Screen readers receive descriptive labels on icons, buttons, modals, and menus everywhere.
                </div>
            </div>
            <div class="fcs">
                <div class="fcs-icon"><i class="fa-solid fa-hand-pointer"></i></div>
                <div class="fcs-title">Minimum Touch Targets</div>
                <div class="fcs-desc">
                    Buttons and links sized to minimum touch target standards for comfortable tapping on touchscreens.
                </div>
            </div>
        </div>
    </div>
</section>

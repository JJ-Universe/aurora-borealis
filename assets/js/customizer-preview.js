( function( wp, $ ) {
    if ( ! wp || ! wp.customize ) return;

    var settings = {
        accent: 'aurora_accent_color',
        accent2: 'aurora_accent_color_2',
        headerOpacity: 'aurora_header_opacity',
        heroMin: 'aurora_hero_min_height',
        logoMax: 'aurora_logo_max_width',
        baseFont: 'aurora_base_font_size',
        hScale: 'aurora_heading_scale',
        heroEnable: 'aurora_hero_enable',
        logoFit: 'aurora_logo_fit_mode'
        ,
        menuText: 'aurora_menu_text_color',
        menuHover: 'aurora_menu_hover_color',
        menuBg: 'aurora_menu_bg_color',
        menuFont: 'aurora_menu_font_size',
        mobileAlign: 'aurora_mobile_menu_align',
        mobileFull: 'aurora_mobile_full_bleed',
        mobileBp: 'aurora_mobile_breakpoint'
    };

    // Small map for font stacks used in live preview. Keys match Customizer choices.
    var FONT_STACKS = {
        'system-ui': 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        'Montserrat': 'Montserrat, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        'Open Sans': '"Open Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        'Roboto': 'Roboto, system-ui, -apple-system, "Segoe UI", "Helvetica Neue", Arial, sans-serif',
        'Lora': 'Lora, Georgia, "Times New Roman", Times, serif',
        'Georgia': 'Georgia, serif'
    };

    // Palette bindings (minimal palette) — map palette settings to theme vars used in CSS
    try {
        wp.customize( 'aurora_primary_color', function( value ){ value.bind( function( newval ){ setVar( '--primary', newval ); setVar( '--accent', newval ); } ); } );
        wp.customize( 'aurora_secondary_color', function( value ){ value.bind( function( newval ){ setVar( '--secondary', newval ); setVar( '--accent-2', newval ); } ); } );
        wp.customize( 'aurora_bg_color', function( value ){ value.bind( function( newval ){ setVar( '--bg-1', newval ); } ); } );
        wp.customize( 'aurora_bg_color_2', function( value ){ value.bind( function( newval ){ setVar( '--bg-2', newval ); } ); } );
        wp.customize( 'aurora_panel_color', function( value ){ value.bind( function( newval ){ setVar( '--panel', newval ); } ); } );
        wp.customize( 'aurora_text_color', function( value ){ value.bind( function( newval ){ setVar( '--text', newval ); } ); } );
        wp.customize( 'aurora_muted_color', function( value ){ value.bind( function( newval ){ setVar( '--muted', newval ); } ); } );
        wp.customize( 'aurora_link_color', function( value ){ value.bind( function( newval ){ setVar( '--link-color', newval ); } ); } );
        wp.customize( 'aurora_button_color', function( value ){ value.bind( function( newval ){ setVar( '--button-bg', newval ); } ); } );
    } catch( e ){}

    // Typography bindings
    try {
        wp.customize( 'aurora_body_font', function( value ){ value.bind( function( newval ){ var stack = FONT_STACKS[ newval ] || newval; setVar( '--body-font', stack ); } ); } );
        wp.customize( 'aurora_heading_font', function( value ){ value.bind( function( newval ){ var stack = FONT_STACKS[ newval ] || newval; setVar( '--heading-font', stack ); } ); } );
    } catch( e ){}

    // Update CSS variable helper
    function setVar( name, value ){
        try { document.documentElement.style.setProperty( name, value ); } catch( e ){}
    }

    // Simple hex darken helper for preview (returns hex). factor: 0..1 (e.g. 0.92)
    function darkenHex( hex, factor ){
        try{
            if ( ! hex || hex.indexOf('#') !== 0 ) return hex;
            var c = hex.substring(1);
            if ( c.length === 3 ) c = c.split('').map(function(ch){ return ch + ch; }).join('');
            var num = parseInt( c, 16 );
            var r = Math.max(0, Math.min(255, Math.floor(((num >> 16) & 0xFF) * factor)));
            var g = Math.max(0, Math.min(255, Math.floor(((num >> 8) & 0xFF) * factor)));
            var b = Math.max(0, Math.min(255, Math.floor((num & 0xFF) * factor)));
            return '#' + [r,g,b].map(function(v){ var s = v.toString(16); return s.length<2 ? '0'+s : s; }).join('');
        }catch(e){ return hex; }
    }

    // Live-update color values
    wp.customize( settings.accent, function( value ){
        value.bind( function( newval ){
            setVar( '--accent', newval );
            setVar( '--accent-2', wp.customize( settings.accent2 ).get() );
        } );
    } );

    wp.customize( settings.accent2, function( value ){
        value.bind( function( newval ){
            setVar( '--accent-2', newval );
        } );
    } );

    // Header opacity
    wp.customize( settings.headerOpacity, function( value ){
        value.bind( function( newval ){
            setVar( '--header-opacity', newval );
            var floatVal = parseFloat( newval );
            if ( ! isNaN( floatVal ) ) setVar( '--header-opacity-2', Math.max(0, floatVal - 0.2) );
        } );
    } );

    // Hero min height (px)
    wp.customize( settings.heroMin, function( value ){
        value.bind( function( newval ){
            setVar( '--hero-min-height', (parseInt( newval, 10 ) || 360) + 'px' );
        } );
    } );

    // Logo max width
    wp.customize( settings.logoMax, function( value ){
        value.bind( function( newval ){
            setVar( '--logo-max-width', (parseInt( newval, 10 ) || 200) + 'px' );
        } );
    } );

    // Base font size
    wp.customize( settings.baseFont, function( value ){
        value.bind( function( newval ){
            setVar( '--base-font-size', (parseInt( newval, 10 ) || 16) + 'px' );
        } );
    } );

    // Heading scale
    wp.customize( settings.hScale, function( value ){
        value.bind( function( newval ){
            setVar( '--h1-scale', parseFloat( newval ) || 1.8 );
        } );
    } );

    // Toggle hero visibility (quick client-side show/hide)
    wp.customize( settings.heroEnable, function( value ){
        value.bind( function( newval ){
            if ( newval ) {
                document.body.classList.add( 'has-hero' );
            } else {
                document.body.classList.remove( 'has-hero' );
            }
        } );
    } );

    // Logo fit mode: add or remove a body class so front-end CSS can respond
    wp.customize( settings.logoFit, function( value ){
        value.bind( function( newval ){
            if ( 'width' === newval ) {
                document.body.classList.add( 'logo-fit-width' );
            } else {
                document.body.classList.remove( 'logo-fit-width' );
            }
        } );
    } );

    // Menu colors and font size
    wp.customize( settings.menuText, function( value ){
        value.bind( function( newval ){
            setVar( '--menu-text-color', newval );
        } );
    } );
    wp.customize( settings.menuHover, function( value ){
        value.bind( function( newval ){
            setVar( '--menu-hover-color', newval );
        } );
    } );
    wp.customize( settings.menuBg, function( value ){
        value.bind( function( newval ){
            setVar( '--menu-bg-color', newval || 'transparent' );
        } );
    } );
    wp.customize( settings.menuFont, function( value ){
        value.bind( function( newval ){
            setVar( '--menu-font-size', (parseInt( newval, 10 ) || 16) + 'px' );
        } );
    } );

    // Mobile menu layout and behavior
    wp.customize( settings.mobileAlign, function( value ){
        value.bind( function( newval ){
            document.documentElement.style.setProperty( '--mobile-menu-align', newval );
        } );
    } );
    wp.customize( settings.mobileFull, function( value ){
        value.bind( function( newval ){
            if ( newval ) document.body.classList.add( 'mobile-menu-full-bleed' ); else document.body.classList.remove( 'mobile-menu-full-bleed' );
        } );
    } );
    wp.customize( settings.mobileBp, function( value ){
        value.bind( function( newval ){
            setVar( '--mobile-breakpoint', (parseInt( newval, 10 ) || 780) + 'px' );
        } );
    } );

    // Footer text selective-refresh will handle content updates, but keep a listener to update preview in case selective refresh isn't available.
    try {
        wp.customize( 'aurora_footer_text', function( value ){
            value.bind( function( newval ){
                var el = document.querySelector( '.site-footer-text' );
                if ( el ) el.innerHTML = newval;
            } );
        } );
    } catch( e ){}

} )( window.wp, jQuery );

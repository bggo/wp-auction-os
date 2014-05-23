(function( $ ) {
	$(document).ready(function(){
		/*
		* include new function centralHassAttr
		*/
		$.fn.centralHassAttr = function( name ) {
			return this.attr(name) !== undefined;
		};
	
		/*
		* display middle letter of blogname in orange color, 
		* variable blogName we get from functions.php
		*/
		var blogNameArray = blogName.split( "" ); /* split 'string' in to 'array' */
		var arrayLength = blogNameArray.length; /* we get size of array */
		var middle = Math.floor( arrayLength/2 ); /* we get nuvber of middle letter */
		var firstLetters = blogNameArray[0]; /* we skid a first letter in to firstLetters */
		var midLetter = blogNameArray[middle]; /* we skid a middle letter in to midLetter */
		var lastLetters=blogNameArray[middle+1]; /* we skid a next letter after the nmiddle letter in to lastLetters */
		var i;
		for ( i = 1; i < middle; i++ ) { /* we add all letters before a middle in to firstLetters */
			firstLetters+=blogNameArray[i];
		}
		for ( i = middle + 2; i < arrayLength; i++ ) { /* we add all letters afetr a middle in to lastLetters */
			lastLetters += blogNameArray[i];
		}
		
		/* we create 'span' elements and and entered text in them */
		$( '#site-title span a' ).append('<span id=first-letters></span>')
			.append('<span id=middle-letter></span>')
			.append('<span id=last-letters></span>');
		$( '#first-letters' ).text( firstLetters );
		$( '#middle-letter' ).text(midLetter);
		$( '#last-letters' ).text(lastLetters);
	
		/*
		* main menu slide
		*/
		/* align center */
		$( '.main-menu' ).css( 'marginLeft', ( 940 - $( '.main-menu' ).width() ) / 2 + 'px' );
	
		/* slide for multilevel lists */
		$('.main-menu li').mouseenter( function() { 
			/*we get rest space from current sub menu to right side of window */
			var windowWidth = $( window ).width();
			var parentWidth = $( this ).width();
			var offset = $( this ).offset();
			var parentLeftOffset = offset.left;
			var restSpace = windowWidth - parentLeftOffset - parentWidth;
				/* displaying next sub menu right or left of the previous sub menu */
				if( restSpace < 218 && ( $( this ).parent().hasClass( 'sub-menu' ) || $( this ).parent().hasClass( 'children' ) ) ) {
					$( this ).children( 'ul' ).css( 'marginLeft', '-220px' );
				}
				$( this ).children( 'ul' ).slideToggle( 300 );
					} ).mouseleave( function() {
						$( this ).children( 'ul' ).slideToggle( 300 );
		});
		
		/*
		* main menu last child for ie
		*/
		$( '#ie7 .sub-menu, #ie8 .sub-menu,#ie7 .children, #ie8 .children' ).each( function() {
			$( this ).children( 'li' ).last().css( 'border', 'none' );
		});
	
		/*
		* slider script
		*/
		var count = 0; /* number of slides*/
		 $( '.slider-wrap .slider ul' ).children( 'li' ).each( function() {
			if( $( this ).parent().hasClass( 'slides' ) )
				count++;
		});
		var currentSlide = 0;  /* number of current slide */
		var nextSlide = 0; /* number of next slide */
		var lastSlide = count - 1; /* number of last slide */
		var timeout = 0;
		$( '.slider-wrap .slider' ).children().children( 'li' ).each( function(i) {	
			$( this ).addClass( 'slide-'+i );
			$( '.slider-nav' ).append( '<a href=\"javascript:void(0);\" class=nav-' + i + '>' + i + '</a>' );
		});

		/* display first slide and show current link */
		$( '.nav-0' ).addClass( 'current-nav' );
		$( '.slide-0' ).addClass( 'current-slide' );
		/* when link was clicked */
		$( '.slider-nav a' ).click( function(){
			clearInterval( timeout ); /* stop centralCicle() */
			currentSlide = parseInt( $( this ).text() );
			if( ! $( this ).hasClass( 'current-nav' ) ) { /* add a class 'current-nav' to the link that was clicked */
				$( '.slider-nav a' ).each( function() {
					if ( $( this ).hasClass( 'current-nav' ) )
						$( this ).removeClass( 'current-nav' );
					});
			}
			$( this ).addClass( 'current-nav' );
			$( '.slider-wrap .slider ul li' ).each( function() { /* add a class 'current-slide' class to the corresponding list item and displey him */
				if ( $( this ).hasClass( 'current-slide' ) )
					$( this ).removeClass( 'current-slide' ).fadeOut( 3000 );
				});
			$( '.slide-' + currentSlide ).addClass( 'current-slide' ).fadeIn( 3000 );
			timeout = setInterval( centralCicle, 7000 ); /* start centralCicle() */
		});
	
		/* function to change slides */
		function centralCicle() {
			currentSlide = parseInt( $( '.current-nav' ).text() );
			if ( currentSlide == lastSlide ) {
				nextSlide = 0;
			} else
				nextSlide = currentSlide + 1;
			$( '.nav-' + currentSlide ).removeClass( 'current-nav' );
			$( '.nav-' + nextSlide ).addClass( 'current-nav' );
			$( '.slide-' + currentSlide ).removeClass( 'current-slide' ).fadeOut( 3000 );
			$( '.slide-' + nextSlide ).addClass( 'current-slide' ).fadeIn( 3000 );
		}
		timeout = setInterval( centralCicle, 7000 );
		
		/* slide navigation script, align center */
		$( '.slider-nav' ).css( "left", ( 940-$( '.slider-nav' ).width() ) / 2 - 3 + 'px' ); 
		
		/*
		* attribut "placeholder" for ie script
		*/
		$(function() {
			var input = document.createElement( "input" );
			 if ( ( 'placeholder' in input ) == false ) {
				$( '[placeholder]' ).focus( function() {
					if ( $( this ).val() == $( this ).attr( 'placeholder' ) ) {
						$( this ).val( '' ).removeClass( 'placeholder' );					
					}
				}).blur( function() {
					if ( $( this ).val() == '' || $( this ).val() == $( this ).attr( 'placeholder' ) )
						$( this ).addClass( 'placeholder' ).val( $( this ).attr( 'placeholder' ) );
				}).blur().parents( 'form' ).submit( function() {
					$( this ).find( '[placeholder]' ).each( function() {
						if( $( this ).val() == $( this ).attr( 'placeholder' ) )
							$( this ).val( '' );
						});
					});
			};
		});
		$( '#ie7 .widget, #ie7 .search-wrap, #ie7 .post' ).before( '<div class="clear"></div>' );
		
		/*
		* search script script
		*/
		$( '.search-wrap' ).each( function() {
			if ( $( this ).parent().hasClass( 'widget' ) )
				$( this ).parent().removeClass( 'widget' ); 
		});
		$( '#ie7 .search-wrap, #ie8 .search-wrap' ).append( '<div class="search-image"></span>' );
		$( '#ie7 .search-field, #ie8 .search-field' ).focus( function() {
			$( this ).css( { top: '-1px',
					left: '-1px',
					padding: '15px 20px',
					border: '1px solid #d9d7d5',
					boxShadow: '0px 0px 5px rgba(220,220,220,1)'
			});
				}).blur( function() {
					$( this ).css( { top: '5px',
							left: '5px',
							padding: '10px 15px',
							border: 'none',
							boxShadow: '0px 0px 5px rgba(255, 255, 255, 1)'
					});
		});
		
		/*
		* widget menu slide script
		*/
		$( '.widget ul li' ).mouseenter( function() {
								$( this ).children( 'ul' ).slideToggle( 300 );
							}).mouseleave( function() {
								$( this ).children( 'ul' ).slideToggle( 300 );
		});
		
		/*
		* input[type="text,password"] and textarea script  
		*/
		$( '#ie7 textarea, #ie8 textarea' ).wrap( ' <div class="textarea-wrap"> ' );
		$( '#ie7 .post input:text, #ie8 .post input:text, #ie7 .post  input:password, #ie8 .post input:password' ).each(function() {
			if( ! $( this ).hasClass( 'search-field' ) ) 
				$( this ).wrap( '<div class="input-wrap">' );
		});
		
		/* function to show animation effects when elements in focus or blur */
		$( '#ie7 textarea, #ie8 textarea, #ie7 .post input:text, #ie8 .post input:text, #ie7 input:password, #ie8 input:password' ).each( function() {
			if( ! $( this ).hasClass( 'search-field' ) ) {
				var normalWidth = $( this ).width();
				var focusWidth = normalWidth + 10;
				var normalHeight = $( this ).height();
				var focusHeight = normalHeight + 10;
				$( this ).focus( function() {
						$( this ).css( { width: focusWidth,
								height: focusHeight,
								top: '-1px',
								left: '-1px',
								border: '1px solid #e7e6e5',
								boxShadow: '0px 0px 5px rgba(220,220,220,1)'
						});
						var id = $( 'html' ).attr( 'id' );
						if ( id == 'ie7' ) {
							$( this ).css( { top: '0px',
									left: '0px'
							});
						}
					}).blur( function() {
						$( this ).css( { width: normalWidth,
								height: normalHeight,
								top: '5px',
								left: '5px',
								border: 'none',
								boxShadow: '0px 0px 5px rgba(255, 255, 255, 1)' 
						});
					});
			}
		}); 
	
		/*
		* select script
		*/
		$( 'select' ).addClass( 'sel-styled' ).wrap( '<div class="sel-styled-cont">' ); 
		$( '#ie7 .sel-styled-cont, #ie8 .sel-styled-cont' ).wrap( '<div class="select-wrap">' );
		$( '.sel-styled-cont' ).append( '<span class="sel-styled-inner"></span>' )
			.append('<div class="sel-styled-cont-open"></div>')
			.each( function() {
				var id = $( 'html' ).attr( 'id' );
				$( this ).mouseenter( function() {
					$( this ).addClass( 'out-shadow' );
					if ( id == 'ie7' || id == 'ie8' ) { /* animation effects for select in ie when select in focus or blur */
						$( this ).css( { top: '0px',
								left: '0px',
								width: '220px',
								height: '44px',
								border: '1px solid #e7e6e5',
								boxShadow: '0px 0px 5px rgba(220, 220, 220, 1)'
						});  
						$( this ).children( '.sel-styled-inner' ).css( { top:'17px',
												right: '19px'
						});
						$( this ).children( '.sel-styled-text' ).css( { top: '4px',
												left: '1px'
						});
					}
					$( this ).children( '.sel-styled-cont-open' ).slideToggle( 300 ); 
					/* set values from dropdawn menu inem to select main field */
					$( this ).children( '.sel-styled-cont-open' ).children( '.sel-styled-opt' ).click( function() {
						$( this ).parent().parent().children( '.sel-styled-text' ).text( $( this ).text() );
						$( this ).parent().parent().children( '.sel-styled' ).val( $( this ).text() );
					});
				}).mouseleave( function() {
					$( this ).removeClass( 'out-shadow' );
						if ( id == 'ie7' || id == 'ie8' ) {
							$( this ).css( { top: '5px',
									left: '5px',
									width: '210px',
									height: '34px',
									border: 'none',
									boxShadow: '0px 0px 5px rgba(255, 255, 255, 1)'
							});
							$( this ).children( '.sel-styled-inner' ).css( { top: '12px',
													right: '14px'
							});
							$( this ).children( '.sel-styled-text' ).css( { top: '-1px',
													left: '-4px'
							});
						}
					$( this ).children( '.sel-styled-cont-open' ).slideToggle( 300 );
				});
			});  
		$( 'select' ).each( function() { /* script for child elements of script */
						$( this ).parent().append( '<span class="sel-styled-text">' + $( this ).val() + '</span>' ); 
					}).children( 'option' ).each( function() {
						if ( $ ( this ).attr( 'disabled' ) ) {
							$( this ).parent().parent().children( '.sel-styled-cont-open' ).append( '<div class="sel-styled-opt-dis">' + 	$( this ).text() + '</div>' );
						} else {
							$( this ).parent().parent().children( '.sel-styled-cont-open' ).append( '<div class="sel-styled-opt">' + $( this ).text() + '</div>' );
						}
					}).children( 'optgroup' ).each( function() {
						$( this ).parent().parent().children( '.sel-styled-cont-open' ).append( '<div class="sel-styled-opt-dis">' + $( this ).text() + '</div>' );
		}); 

		/*
		* radioboxes script
		*/
		$( 'input:radio' ).addClass( 'rad-styled' ).wrap( '<div class="rad-styled-cont">' ).click( function() {
			$( 'input:radio' ).each( function() {
				if ( $( this ).parent().hasClass( 'checked' ) )
					$( this ).parent().removeClass( 'checked' );
			});
			$( this ).parent().addClass( 'checked' );
		});
		$( 'input:radio:checked' ).parent().addClass( 'checked' );
		$( '.rad-styled-cont' ).append( '<span class="rad-styled-inner"></span>' );
	
		/*
		* checkbox script
		*/
		$( 'input:checkbox' ).addClass( 'che-styled' ).wrap( '<div class="che-styled-cont">' ).click( function() {
			$( this ).parent().toggleClass( 'checked' );
		} ); 
		$( 'input:checkbox:checked' ).parent().addClass( 'checked' );
		$( '.che-styled-cont' ).append( '<span class="che-styled-inner"></span>' );
		$( '.che-styled-inner ').click( function() {
			$( this ).parent().removeClass( 'checked' );
			if ( $( this ).parent().children( 'input:checkbox' ).centralHassAttr( 'checked' ) ) {
				$( this ).parent().children( 'input:checkbox' ).removeAttr( 'checked' );
			}
		});
		
		/*
		* labels of radioboxes and checkboxes script
		*/
		$( '.rad-styled-cont, .che-styled-cont' ).next( 'label' ).each( function() {
			$( this ).addClass( 'form-label' );
		} );
		
		/*
		* file-input script, variables chooseFile, fileSelected and fileNotSelected we get from functions.php
		*/
		$( 'input:file' ).addClass( 'file-styled' ).wrap( '<div class="file-styled-cont">' ).change( function() {
			var path = $( this ).val();
			if ( path ){
				$( this ).parent().children( '.file-styled-inner' ).text( path );
				$( this ).parent().children( '.file-styled-validator' ).text( fileSelected );
			} else {
				$( this ).parent().children( '.file-styled-inner' ).text( chooseFile );
				$( this ).parent().children( '.file-styled-validator' ).text( fileNotSelected );
			}
		});
		$( '.file-styled-cont' ).wrap( '<div class="file-input-form">' )
			.append('<span class="file-styled-inner"></span>')
			.append('<span class="file-styled-arrow"></span>')
			.append('<span class="file-styled-validator"></span>');
		$( '.file-styled-inner' ).text( chooseFile );
		$( '.file-styled-validator' ).text( fileNotSelected );
		
		/*
		* animate buttons script
		*/
		$( 'button, input:reset, input:button, input:submit' ).mouseenter( function() {
				$( this ).animate( { boxShadow: '0 0 5px #bbb',
						backgroundColor: '#333'
				}, 300 );
			}).mouseleave( function() {
				$( this ).animate( { boxShadow: '0 0 0 #bbb',
						backgroundColor: '#e37351'
				}, 300 );
			}).click( function() {
				$( this ).animate( { boxShadow: '0 0 0 #bbb',
						backgroundColor: '#333'
				}, 300 );
		});
		
		/* 
		* reset button script
		*/
		$( 'input:reset' ).click( function() {
			$( 'option' ).each( function() { 
				if ( $( this ).centralHassAttr( 'selected' ) )
					$( '.sel-styled-text' ).text( $( this ).text() );  
				else 
					$( '.sel-styled-text' ).text( $( '.sel-styled-opt:first' ).text() );
			});
			$( 'input:radio' ).each( function() {
				$( this ).parent().removeClass( 'checked' );
				if ( $( this ).hasAttr( 'checked' ) )
					$( 'input:radio:checked' ).parent().addClass( 'checked' );
			});
			$( 'input:checkbox' ).each( function() {
				$( this ).parent().removeClass( 'checked' );
			});
			$( 'input:file' ).each( function() {
				$( this ).val( '' ); 
				$( '.file-styled-inner' ).text( chooseFile );
				$( '.file-styled-validator' ).text( fileNotSelected );
			});
		});
		$( '.anchor' ).click( function () {
			$( 'html' ).animate( { scrollTop: 0 }, 2000 );
		} );
	
		/*
		* blockquote in ie7 script
		*/
		$( '#ie7 blockquote' ).each( function() {
			var text = '\"' + $( this ).children( 'p' ).text() + '\"';
			$( this ).children( 'p' ).text( text ).before( '<div class="blockquote-before"></div>' );
		} );
	
		/*
		* quote in ie7 script
		*/
		$( '#ie7 q' ).each( function() {
			var text = '\"' + $( this ).text() + '\"';
			$( this ).text( text );
		});
	})
})(jQuery);


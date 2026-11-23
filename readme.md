=== Plugin Name ===
Contributors: digihood
Donate link: https://digihood.cz/
Tags: v3.1.3
Requires at least: 4.0
Tested up to: 6.6.2
Stable tag: 5.1.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==
Branding plugin pro klienty WeDesIn a dogihood.
**verze 5.1.7** Nové kontaktní telefonní číslo
- V dashboard widgetu a na stránce pluginů změněno telefonní číslo na +420 777 657 474

**verze 5.1.6** Oprava neviditelného hesla při resetu + odstranění debug endpointu
- Branding login stránky se nově aplikuje i na formuláře resetu hesla, zapomenutého hesla a registrace — dřív stylsoval jen #loginform, ale bílý text inputů platil všude, takže na #resetpassform zůstalo bílé pozadí z jádra pod bílým textem a zadané heslo nebylo vidět
- Doplněny nápovědy pod poli, metr síly hesla, tlačítko "Generovat heslo" a input[type=email] z registrace
- Z e-mailové třídy frameworku odstraněn debug endpoint ?showmail=1, který bez kontroly oprávnění vypsal testovací šablonu a ukončil request

**verze 5.1.5** Oprava PHP warningů při ukládání příspěvků (CF7)
- saveForm::save_handler už nesahá přímo do pole get_post_types() podle neověřeného $_REQUEST['post_type'] — použit post_type_exists() nad sanitizovanou hodnotou
- Tím zmizí "Undefined array key" v admin_init a navazující "Cannot modify header information – headers already sent" (projevovalo se např. při zakládání formuláře Contact Form 7)
- Ošetřen i případ, kdy post_type/submit dorazí jako pole (dříve TypeError na PHP 8)

**verze 5.1.4** Framework přímo v balíčku (oprava aktualizací)
- plugin-framework převeden z git submodulu na běžné soubory v repu — framework je nyní v každém distribučním kanálu (release asset, GitHub source zip i git clone)
- Opraven případ, kdy klasická WP aktualizace (PUC) stáhla source archiv bez submodulu → plugin hlásil chybějící plugin-framework

**verze 5.1.3** Odolnost při chybějícím frameworku + auto-aktualizace
- Plugin se při chybějících souborech složky plugin-framework (např. nasazení bez submodulu) elegantně zastaví a zobrazí adminovi hlášku místo fatální chyby (white-screen)
- Vynucené automatické aktualizace pluginu — klientské weby si budoucí verze stáhnou samy (PUC + WP cron) bez ručního zásahu
- Odstraněn mrtvý kód (filtr type="module" pro již smazané gradient skripty)

**verze 5.1.2** Opravy fatální chyby na PHP 8.x a ukládání nastavení
- Ošetření prázdné (null/false) hodnoty u filtrů admin_footer_text a get_user_option_admin_color
- Odstranění TypeError při prázdném textu patičky administrace
- Ukládání e-mailové konfigurace funguje i bez JS (fallback přes admin-post.php) — odstraněn prázdný admin.php a únik e-mailu do URL při selhání JS

**verze 5.1.1** Drobné interní úpravy a údržba

**verze 5.1.0** Redesign pozadí a sjednocení admin barev
- Nahrazení externího mesh-gradient skriptu (CDN) vlastní CSS animací — bez externí závislosti
- Přepracované pozadí login i admin stránek (teplý gradient s jemnými barevnými akcenty v brand barvách)
- Vynucení digihood admin color scheme pro všechny uživatele
- Lososové akcenty místo defaultní WP modré napříč adminem (vč. blokového editoru přes --wp-admin-theme-color)
- Drobná úprava login formuláře (odsazení tlačítka)

**verze 3.1.3** Aktualizace frameworku
- Aktualizace frameworku na nejnovější verzi.
- Převedení frameworku na submodule jako v ostatních pluginech.

**verze 3.1.2** Odstranění varování při aktivaci pluginu
- Odstranění chyby, která se při aktivaci pluginy zobrazovala v administraci
- Odstranění zbytečných souborů z masteru
- Zlepšená kompatibilita s ostatnámi pluginy

**verze 3.1.1** Nový github
- Změna na novou adresu repozitáře githubu (z wedesin na digihood)

**verze 3.1.0** Změna jádra pluginu 
- Úprava práce s formulářem v administraci
- Změna v odesílání hlášení o aktualizaci
- Změna umístění pluginu v administraci
- Změna vzhledu
- Odstranění problému s aktivní sessions
- Odstranění zastaralých funkcí
- Kompatibilita s php 8.1
- Příprava na php 8.2

**verze 3.0.1** Změna brandingu 
- Úprava branding barev

**verze 3.0.0** Změna brandingu 
- Změna branding barev

verze 2.3.4=
oprava CSS frondendu pro nepřihlášené uživatele

verze 2.3.3=
úprava stylů pro jádro pluginu
odstranění notice u odesílaných formulářů (chybný parametr $atts)
příprava na novou verzi jádra pluginu

verze 2.3.2=
oprava odchozích emailu 

verze 2.3.1=
přidán monolog

=verze 2.3.0=

Oprava CSS Emailu
Oprava session
Kategorizace funkcí v jadru pluginu

=verze 2.2.1=
Změna prefixu funkci pluginu.

=verze 2.2.0=
Spuštení distribuce pro klienty wedesin.

=verze 2.1.1=
Úprava jádra pluginů.

Přechod na standart digihood
změna nastavení administrace aktualizací
úprava funkcí pro aktualizace
přidání kontroly minimálních požadavků pro aktivaci pluginu
odstranění nepotřebných souborů z masteru
úprava emailů

=verze 2.1.0= 
Úprava administrace aktualizací a odesílání reportu.

Nyní se odesílají emaily pouze v případě, že je vyplněna aktualizace.
Redesign sekce s návratovou hodnotou po zpracování formulářů.
Redesign šablony emailu.
Oprava zobrazování času aktualizace v administraci podle časového pásma
Oprava postranní widgety v administraci

<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Arquivo de idioma para theme_ufpel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Strings gerais.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'UFPel é um tema moderno baseado no Boost, personalizado para a Universidade Federal de Pelotas.';

// Strings da página de configurações.
$string['configtitle'] = 'Configurações do tema UFPel';
$string['generalsettings'] = 'Configurações gerais';
$string['advancedsettings'] = 'Configurações avançadas';
$string['features'] = 'Recursos';
$string['default'] = 'Padrão';

// Configurações de preset.
$string['preset'] = 'Predefinição do tema';
$string['preset_desc'] = 'Escolha uma predefinição para alterar amplamente a aparência do tema.';
$string['presetfiles'] = 'Arquivos de predefinição adicionais do tema';
$string['presetfiles_desc'] = 'Arquivos de predefinição podem ser usados para alterar drasticamente a aparência do tema. Veja <a href="https://docs.moodle.org/dev/Boost_Presets">Predefinições do Boost</a> para informações sobre criar e compartilhar seus próprios arquivos de predefinição.';

// Configurações de cores.
$string['primarycolor'] = 'Cor primária';
$string['primarycolor_desc'] = 'A cor primária do tema. Será usada para elementos principais como cabeçalho e botões.';
$string['secondarycolor'] = 'Cor secundária';
$string['secondarycolor_desc'] = 'A cor secundária para o tema. Usada para links e elementos secundários.';
$string['backgroundcolor'] = 'Cor de fundo';
$string['backgroundcolor_desc'] = 'A cor de fundo principal para as páginas do site.';
$string['highlightcolor'] = 'Cor de destaque';
$string['highlightcolor_desc'] = 'A cor usada para destacar elementos importantes e acentos.';
$string['contenttextcolor'] = 'Cor do texto de conteúdo';
$string['contenttextcolor_desc'] = 'A cor para o texto geral de conteúdo em todo o site.';
$string['highlighttextcolor'] = 'Cor de destaque do texto';
$string['highlighttextcolor_desc'] = 'A cor para textos que aparecem em fundos com cor primária.';

// Configurações de logotipo.
$string['logo'] = 'Logotipo';
$string['logo_desc'] = 'Faça upload do logotipo da instituição. Isso substituirá o nome do site na barra de navegação.';

// Configurações de CSS personalizado.
$string['customcss'] = 'CSS personalizado';
$string['customcss_desc'] = 'Quaisquer regras CSS que você adicionar a esta área de texto serão refletidas em todas as páginas, facilitando a personalização deste tema.';

// Configurações da página de login.
$string['loginbackgroundimage'] = 'Imagem de fundo da página de login';
$string['loginbackgroundimage_desc'] = 'Uma imagem que será esticada para preencher o fundo da página de login.';

// Configurações de favicon.
$string['favicon'] = 'Favicon';
$string['favicon_desc'] = 'Faça upload de um favicon personalizado. Deve ser um arquivo .ico, .png ou .svg.';

// Configurações de fontes.
$string['customfonts'] = 'URL de fontes personalizadas';
$string['customfonts_desc'] = 'Insira a URL para importar fontes personalizadas (ex: Google Fonts). Use a tag @import completa.';

// Configurações avançadas.
$string['rawscss'] = 'SCSS adicional';
$string['rawscss_desc'] = 'Use este campo para fornecer código SCSS que será injetado no final da folha de estilo.';
$string['rawscsspre'] = 'SCSS de inicialização';
$string['rawscsspre_desc'] = 'Neste campo você pode fornecer código SCSS de inicialização, ele será injetado antes de todo o resto. Na maioria das vezes você usará esta configuração para definir variáveis.';

// Configurações de recursos.
$string['showcourseimage'] = 'Mostrar imagem do curso';
$string['showcourseimage_desc'] = 'Exibir a imagem do curso no cabeçalho das páginas do curso.';
$string['showteachers'] = 'Mostrar professores';
$string['showteachers_desc'] = 'Exibir os nomes dos professores no cabeçalho das páginas do curso.';
$string['courseheaderoverlay'] = 'Sobrepor cabeçalho do curso';
$string['courseheaderoverlay_desc'] = 'Adicionar uma sobreposição escura ao cabeçalho do curso para melhorar a legibilidade do texto.';
$string['footercontent'] = 'Conteúdo do rodapé';
$string['footercontent_desc'] = 'Conteúdo HTML personalizado para exibir no rodapé do site.';

// Strings de privacidade.
$string['privacy:metadata'] = 'O tema UFPel não armazena nenhum dado pessoal.';

// Strings de região.
$string['region-side-pre'] = 'Esquerda';
$string['region-side-post'] = 'Direita';

// Strings da página do curso.
$string['teacher'] = 'Professor(a)';
$string['teachers'] = 'Professores';

// Strings para templates.
$string['courseheader'] = 'Cabeçalho do curso';

// Strings de acessibilidade.
$string['skipto'] = 'Pular para {$a}';
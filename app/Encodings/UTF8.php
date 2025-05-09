<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2025 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Encodings;

use InvalidArgumentException;

use function chr;
use function mb_substitute_character;

/**
 * Convert between (potentially invalid) UTF-8 and UTF-8.
 */
class UTF8 extends AbstractEncoding
{
    public const string NAME = 'UTF-8';

    public const string START_OF_STRING                                       = "\u{0098}";
    public const string STRING_TERMINATOR                                     = "\u{009C}";
    public const string NO_BREAK_SPACE                                        = "\u{00A0}";
    public const string INVERTED_EXCLAMATION_MARK                             = "\u{00A1}";
    public const string CENT_SIGN                                             = "\u{00A2}";
    public const string POUND_SIGN                                            = "\u{00A3}";
    public const string CURRENCY_SIGN                                         = "\u{00A4}";
    public const string YEN_SIGN                                              = "\u{00A5}";
    public const string BROKEN_BAR                                            = "\u{00A6}";
    public const string SECTION_SIGN                                          = "\u{00A7}";
    public const string DIAERESIS                                             = "\u{00A8}";
    public const string COPYRIGHT_SIGN                                        = "\u{00A9}";
    public const string FEMININE_ORDINAL_INDICATOR                            = "\u{00AA}";
    public const string LEFT_POINTING_DOUBLE_ANGLE_QUOTATION_MARK             = "\u{00AB}";
    public const string NOT_SIGN                                              = "\u{00AC}";
    public const string SOFT_HYPHEN                                           = "\u{00AD}";
    public const string REGISTERED_SIGN                                       = "\u{00AE}";
    public const string MACRON                                                = "\u{00AF}";
    public const string DEGREE_SIGN                                           = "\u{00B0}";
    public const string PLUS_MINUS_SIGN                                       = "\u{00B1}";
    public const string SUPERSCRIPT_TWO                                       = "\u{00B2}";
    public const string SUPERSCRIPT_THREE                                     = "\u{00B3}";
    public const string ACUTE_ACCENT                                          = "\u{00B4}";
    public const string MICRO_SIGN                                            = "\u{00B5}";
    public const string PILCROW_SIGN                                          = "\u{00B6}";
    public const string MIDDLE_DOT                                            = "\u{00B7}";
    public const string CEDILLA                                               = "\u{00B8}";
    public const string SUPERSCRIPT_ONE                                       = "\u{00B9}";
    public const string MASCULINE_ORDINAL_INDICATOR                           = "\u{00BA}";
    public const string RIGHT_POINTING_DOUBLE_ANGLE_QUOTATION_MARK            = "\u{00BB}";
    public const string VULGAR_FRACTION_ONE_QUARTER                           = "\u{00BC}";
    public const string VULGAR_FRACTION_ONE_HALF                              = "\u{00BD}";
    public const string VULGAR_FRACTION_THREE_QUARTERS                        = "\u{00BE}";
    public const string INVERTED_QUESTION_MARK                                = "\u{00BF}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_GRAVE                     = "\u{00C0}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_ACUTE                     = "\u{00C1}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX                = "\u{00C2}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_TILDE                     = "\u{00C3}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_DIAERESIS                 = "\u{00C4}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_RING_ABOVE                = "\u{00C5}";
    public const string LATIN_CAPITAL_LETTER_AE                               = "\u{00C6}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_CEDILLA                   = "\u{00C7}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_GRAVE                     = "\u{00C8}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_ACUTE                     = "\u{00C9}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX                = "\u{00CA}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_DIAERESIS                 = "\u{00CB}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_GRAVE                     = "\u{00CC}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_ACUTE                     = "\u{00CD}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_CIRCUMFLEX                = "\u{00CE}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_DIAERESIS                 = "\u{00CF}";
    public const string LATIN_CAPITAL_LETTER_ETH                              = "\u{00D0}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_TILDE                     = "\u{00D1}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_GRAVE                     = "\u{00D2}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_ACUTE                     = "\u{00D3}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX                = "\u{00D4}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_TILDE                     = "\u{00D5}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DIAERESIS                 = "\u{00D6}";
    public const string MULTIPLICATION_SIGN                                   = "\u{00D7}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_STROKE                    = "\u{00D8}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_GRAVE                     = "\u{00D9}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_ACUTE                     = "\u{00DA}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_CIRCUMFLEX                = "\u{00DB}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS                 = "\u{00DC}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_ACUTE                     = "\u{00DD}";
    public const string LATIN_CAPITAL_LETTER_THORN                            = "\u{00DE}";
    public const string LATIN_SMALL_LETTER_SHARP_S                            = "\u{00DF}";
    public const string LATIN_SMALL_LETTER_A_WITH_GRAVE                       = "\u{00E0}";
    public const string LATIN_SMALL_LETTER_A_WITH_ACUTE                       = "\u{00E1}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX                  = "\u{00E2}";
    public const string LATIN_SMALL_LETTER_A_WITH_TILDE                       = "\u{00E3}";
    public const string LATIN_SMALL_LETTER_A_WITH_DIAERESIS                   = "\u{00E4}";
    public const string LATIN_SMALL_LETTER_A_WITH_RING_ABOVE                  = "\u{00E5}";
    public const string LATIN_SMALL_LETTER_AE                                 = "\u{00E6}";
    public const string LATIN_SMALL_LETTER_C_WITH_CEDILLA                     = "\u{00E7}";
    public const string LATIN_SMALL_LETTER_E_WITH_GRAVE                       = "\u{00E8}";
    public const string LATIN_SMALL_LETTER_E_WITH_ACUTE                       = "\u{00E9}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX                  = "\u{00EA}";
    public const string LATIN_SMALL_LETTER_E_WITH_DIAERESIS                   = "\u{00EB}";
    public const string LATIN_SMALL_LETTER_I_WITH_GRAVE                       = "\u{00EC}";
    public const string LATIN_SMALL_LETTER_I_WITH_ACUTE                       = "\u{00ED}";
    public const string LATIN_SMALL_LETTER_I_WITH_CIRCUMFLEX                  = "\u{00EE}";
    public const string LATIN_SMALL_LETTER_I_WITH_DIAERESIS                   = "\u{00EF}";
    public const string LATIN_SMALL_LETTER_ETH                                = "\u{00F0}";
    public const string LATIN_SMALL_LETTER_N_WITH_TILDE                       = "\u{00F1}";
    public const string LATIN_SMALL_LETTER_O_WITH_GRAVE                       = "\u{00F2}";
    public const string LATIN_SMALL_LETTER_O_WITH_ACUTE                       = "\u{00F3}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX                  = "\u{00F4}";
    public const string LATIN_SMALL_LETTER_O_WITH_TILDE                       = "\u{00F5}";
    public const string LATIN_SMALL_LETTER_O_WITH_DIAERESIS                   = "\u{00F6}";
    public const string DIVISION_SIGN                                         = "\u{00F7}";
    public const string LATIN_SMALL_LETTER_O_WITH_STROKE                      = "\u{00F8}";
    public const string LATIN_SMALL_LETTER_U_WITH_GRAVE                       = "\u{00F9}";
    public const string LATIN_SMALL_LETTER_U_WITH_ACUTE                       = "\u{00FA}";
    public const string LATIN_SMALL_LETTER_U_WITH_CIRCUMFLEX                  = "\u{00FB}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS                   = "\u{00FC}";
    public const string LATIN_SMALL_LETTER_Y_WITH_ACUTE                       = "\u{00FD}";
    public const string LATIN_SMALL_LETTER_THORN                              = "\u{00FE}";
    public const string LATIN_SMALL_LETTER_Y_WITH_DIAERESIS                   = "\u{00FF}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_MACRON                    = "\u{0100}";
    public const string LATIN_SMALL_LETTER_A_WITH_MACRON                      = "\u{0101}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE                     = "\u{0102}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE                       = "\u{0103}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_OGONEK                    = "\u{0104}";
    public const string LATIN_SMALL_LETTER_A_WITH_OGONEK                      = "\u{0105}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_ACUTE                     = "\u{0106}";
    public const string LATIN_SMALL_LETTER_C_WITH_ACUTE                       = "\u{0107}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_CIRCUMFLEX                = "\u{0108}";
    public const string LATIN_SMALL_LETTER_C_WITH_CIRCUMFLEX                  = "\u{0109}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_DOT_ABOVE                 = "\u{010A}";
    public const string LATIN_SMALL_LETTER_C_WITH_DOT_ABOVE                   = "\u{010B}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_CARON                     = "\u{010C}";
    public const string LATIN_SMALL_LETTER_C_WITH_CARON                       = "\u{010D}";
    public const string LATIN_CAPITAL_LETTER_D_WITH_CARON                     = "\u{010E}";
    public const string LATIN_SMALL_LETTER_D_WITH_CARON                       = "\u{010F}";
    public const string LATIN_CAPITAL_LETTER_D_WITH_STROKE                    = "\u{0110}";
    public const string LATIN_SMALL_LETTER_D_WITH_STROKE                      = "\u{0111}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_MACRON                    = "\u{0112}";
    public const string LATIN_SMALL_LETTER_E_WITH_MACRON                      = "\u{0113}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_BREVE                     = "\u{0114}";
    public const string LATIN_SMALL_LETTER_E_WITH_BREVE                       = "\u{0115}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_DOT_ABOVE                 = "\u{0116}";
    public const string LATIN_SMALL_LETTER_E_WITH_DOT_ABOVE                   = "\u{0117}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_OGONEK                    = "\u{0118}";
    public const string LATIN_SMALL_LETTER_E_WITH_OGONEK                      = "\u{0119}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CARON                     = "\u{011A}";
    public const string LATIN_SMALL_LETTER_E_WITH_CARON                       = "\u{011B}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_CIRCUMFLEX                = "\u{011C}";
    public const string LATIN_SMALL_LETTER_G_WITH_CIRCUMFLEX                  = "\u{011D}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_BREVE                     = "\u{011E}";
    public const string LATIN_SMALL_LETTER_G_WITH_BREVE                       = "\u{011F}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_DOT_ABOVE                 = "\u{0120}";
    public const string LATIN_SMALL_LETTER_G_WITH_DOT_ABOVE                   = "\u{0121}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_CEDILLA                   = "\u{0122}";
    public const string LATIN_SMALL_LETTER_G_WITH_CEDILLA                     = "\u{0123}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_CIRCUMFLEX                = "\u{0124}";
    public const string LATIN_SMALL_LETTER_H_WITH_CIRCUMFLEX                  = "\u{0125}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_STROKE                    = "\u{0126}";
    public const string LATIN_SMALL_LETTER_H_WITH_STROKE                      = "\u{0127}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_TILDE                     = "\u{0128}";
    public const string LATIN_SMALL_LETTER_I_WITH_TILDE                       = "\u{0129}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_MACRON                    = "\u{012A}";
    public const string LATIN_SMALL_LETTER_I_WITH_MACRON                      = "\u{012B}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_BREVE                     = "\u{012C}";
    public const string LATIN_SMALL_LETTER_I_WITH_BREVE                       = "\u{012D}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_OGONEK                    = "\u{012E}";
    public const string LATIN_SMALL_LETTER_I_WITH_OGONEK                      = "\u{012F}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_DOT_ABOVE                 = "\u{0130}";
    public const string LATIN_SMALL_LETTER_DOTLESS_I                          = "\u{0131}";
    public const string LATIN_CAPITAL_LIGATURE_IJ                             = "\u{0132}";
    public const string LATIN_SMALL_LIGATURE_IJ                               = "\u{0133}";
    public const string LATIN_CAPITAL_LETTER_J_WITH_CIRCUMFLEX                = "\u{0134}";
    public const string LATIN_SMALL_LETTER_J_WITH_CIRCUMFLEX                  = "\u{0135}";
    public const string LATIN_CAPITAL_LETTER_K_WITH_CEDILLA                   = "\u{0136}";
    public const string LATIN_SMALL_LETTER_K_WITH_CEDILLA                     = "\u{0137}";
    public const string LATIN_SMALL_LETTER_KRA                                = "\u{0138}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_ACUTE                     = "\u{0139}";
    public const string LATIN_SMALL_LETTER_L_WITH_ACUTE                       = "\u{013A}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_CEDILLA                   = "\u{013B}";
    public const string LATIN_SMALL_LETTER_L_WITH_CEDILLA                     = "\u{013C}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_CARON                     = "\u{013D}";
    public const string LATIN_SMALL_LETTER_L_WITH_CARON                       = "\u{013E}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_MIDDLE_DOT                = "\u{013F}";
    public const string LATIN_SMALL_LETTER_L_WITH_MIDDLE_DOT                  = "\u{0140}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_STROKE                    = "\u{0141}";
    public const string LATIN_SMALL_LETTER_L_WITH_STROKE                      = "\u{0142}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_ACUTE                     = "\u{0143}";
    public const string LATIN_SMALL_LETTER_N_WITH_ACUTE                       = "\u{0144}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_CEDILLA                   = "\u{0145}";
    public const string LATIN_SMALL_LETTER_N_WITH_CEDILLA                     = "\u{0146}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_CARON                     = "\u{0147}";
    public const string LATIN_SMALL_LETTER_N_WITH_CARON                       = "\u{0148}";
    public const string LATIN_SMALL_LETTER_N_PRECEDED_BY_APOSTROPHE           = "\u{0149}";
    public const string LATIN_CAPITAL_LETTER_ENG                              = "\u{014A}";
    public const string LATIN_SMALL_LETTER_ENG                                = "\u{014B}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_MACRON                    = "\u{014C}";
    public const string LATIN_SMALL_LETTER_O_WITH_MACRON                      = "\u{014D}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_BREVE                     = "\u{014E}";
    public const string LATIN_SMALL_LETTER_O_WITH_BREVE                       = "\u{014F}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DOUBLE_ACUTE              = "\u{0150}";
    public const string LATIN_SMALL_LETTER_O_WITH_DOUBLE_ACUTE                = "\u{0151}";
    public const string LATIN_CAPITAL_LIGATURE_OE                             = "\u{0152}";
    public const string LATIN_SMALL_LIGATURE_OE                               = "\u{0153}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_ACUTE                     = "\u{0154}";
    public const string LATIN_SMALL_LETTER_R_WITH_ACUTE                       = "\u{0155}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_CEDILLA                   = "\u{0156}";
    public const string LATIN_SMALL_LETTER_R_WITH_CEDILLA                     = "\u{0157}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_CARON                     = "\u{0158}";
    public const string LATIN_SMALL_LETTER_R_WITH_CARON                       = "\u{0159}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_ACUTE                     = "\u{015A}";
    public const string LATIN_SMALL_LETTER_S_WITH_ACUTE                       = "\u{015B}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_CIRCUMFLEX                = "\u{015C}";
    public const string LATIN_SMALL_LETTER_S_WITH_CIRCUMFLEX                  = "\u{015D}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_CEDILLA                   = "\u{015E}";
    public const string LATIN_SMALL_LETTER_S_WITH_CEDILLA                     = "\u{015F}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_CARON                     = "\u{0160}";
    public const string LATIN_SMALL_LETTER_S_WITH_CARON                       = "\u{0161}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_CEDILLA                   = "\u{0162}";
    public const string LATIN_SMALL_LETTER_T_WITH_CEDILLA                     = "\u{0163}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_CARON                     = "\u{0164}";
    public const string LATIN_SMALL_LETTER_T_WITH_CARON                       = "\u{0165}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_STROKE                    = "\u{0166}";
    public const string LATIN_SMALL_LETTER_T_WITH_STROKE                      = "\u{0167}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_TILDE                     = "\u{0168}";
    public const string LATIN_SMALL_LETTER_U_WITH_TILDE                       = "\u{0169}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_MACRON                    = "\u{016A}";
    public const string LATIN_SMALL_LETTER_U_WITH_MACRON                      = "\u{016B}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_BREVE                     = "\u{016C}";
    public const string LATIN_SMALL_LETTER_U_WITH_BREVE                       = "\u{016D}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_RING_ABOVE                = "\u{016E}";
    public const string LATIN_SMALL_LETTER_U_WITH_RING_ABOVE                  = "\u{016F}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DOUBLE_ACUTE              = "\u{0170}";
    public const string LATIN_SMALL_LETTER_U_WITH_DOUBLE_ACUTE                = "\u{0171}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_OGONEK                    = "\u{0172}";
    public const string LATIN_SMALL_LETTER_U_WITH_OGONEK                      = "\u{0173}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_CIRCUMFLEX                = "\u{0174}";
    public const string LATIN_SMALL_LETTER_W_WITH_CIRCUMFLEX                  = "\u{0175}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_CIRCUMFLEX                = "\u{0176}";
    public const string LATIN_SMALL_LETTER_Y_WITH_CIRCUMFLEX                  = "\u{0177}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_DIAERESIS                 = "\u{0178}";
    public const string LATIN_CAPITAL_LETTER_Z_WITH_ACUTE                     = "\u{0179}";
    public const string LATIN_SMALL_LETTER_Z_WITH_ACUTE                       = "\u{017A}";
    public const string LATIN_CAPITAL_LETTER_Z_WITH_DOT_ABOVE                 = "\u{017B}";
    public const string LATIN_SMALL_LETTER_Z_WITH_DOT_ABOVE                   = "\u{017C}";
    public const string LATIN_CAPITAL_LETTER_Z_WITH_CARON                     = "\u{017D}";
    public const string LATIN_SMALL_LETTER_Z_WITH_CARON                       = "\u{017E}";
    public const string LATIN_SMALL_LETTER_LONG_S                             = "\u{017F}";
    public const string LATIN_SMALL_LETTER_B_WITH_STROKE                      = "\u{0180}";
    public const string LATIN_CAPITAL_LETTER_B_WITH_HOOK                      = "\u{0181}";
    public const string LATIN_CAPITAL_LETTER_B_WITH_TOPBAR                    = "\u{0182}";
    public const string LATIN_SMALL_LETTER_B_WITH_TOPBAR                      = "\u{0183}";
    public const string LATIN_CAPITAL_LETTER_F_WITH_HOOK                      = "\u{0191}";
    public const string LATIN_SMALL_LETTER_F_WITH_HOOK                        = "\u{0192}";
    public const string LATIN_SMALL_LETTER_O_WITH_HORN                        = "\u{01A1}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_HORN                      = "\u{01A0}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_HORN                      = "\u{01AF}";
    public const string LATIN_SMALL_LETTER_U_WITH_HORN                        = "\u{01B0}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CARON                     = "\u{01CD}";
    public const string LATIN_SMALL_LETTER_A_WITH_CARON                       = "\u{01CE}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_CARON                     = "\u{01CF}";
    public const string LATIN_SMALL_LETTER_I_WITH_CARON                       = "\u{01D0}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CARON                     = "\u{01D1}";
    public const string LATIN_SMALL_LETTER_O_WITH_CARON                       = "\u{01D2}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_CARON                     = "\u{01D3}";
    public const string LATIN_SMALL_LETTER_U_WITH_CARON                       = "\u{01D4}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS_AND_MACRON      = "\u{01D5}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS_AND_MACRON        = "\u{01D6}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS_AND_ACUTE       = "\u{01D7}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS_AND_ACUTE         = "\u{01D8}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS_AND_CARON       = "\u{01D9}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS_AND_CARON         = "\u{01DA}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS_AND_GRAVE       = "\u{01DB}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS_AND_GRAVE         = "\u{01DC}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_DIAERESIS_AND_MACRON      = "\u{01DE}";
    public const string LATIN_SMALL_LETTER_A_WITH_DIAERESIS_AND_MACRON        = "\u{01DF}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_DOT_ABOVE_AND_MACRON      = "\u{01E0}";
    public const string LATIN_SMALL_LETTER_A_WITH_DOT_ABOVE_AND_MACRON        = "\u{01E1}";
    public const string LATIN_CAPITAL_LETTER_AE_WITH_MACRON                   = "\u{01E2}";
    public const string LATIN_SMALL_LETTER_AE_WITH_MACRON                     = "\u{01E3}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_CARON                     = "\u{01E6}";
    public const string LATIN_SMALL_LETTER_G_WITH_CARON                       = "\u{01E7}";
    public const string LATIN_CAPITAL_LETTER_K_WITH_CARON                     = "\u{01E8}";
    public const string LATIN_SMALL_LETTER_K_WITH_CARON                       = "\u{01E9}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_OGONEK                    = "\u{01EA}";
    public const string LATIN_SMALL_LETTER_O_WITH_OGONEK                      = "\u{01EB}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_OGONEK_AND_MACRON         = "\u{01EC}";
    public const string LATIN_SMALL_LETTER_O_WITH_OGONEK_AND_MACRON           = "\u{01ED}";
    public const string LATIN_SMALL_LETTER_J_WITH_CARON                       = "\u{01F0}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_ACUTE                     = "\u{01F4}";
    public const string LATIN_SMALL_LETTER_G_WITH_ACUTE                       = "\u{01F5}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_GRAVE                     = "\u{01F8}";
    public const string LATIN_SMALL_LETTER_N_WITH_GRAVE                       = "\u{01F9}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_RING_ABOVE_AND_ACUTE      = "\u{01FA}";
    public const string LATIN_SMALL_LETTER_A_WITH_RING_ABOVE_AND_ACUTE        = "\u{01FB}";
    public const string LATIN_CAPITAL_LETTER_AE_WITH_ACUTE                    = "\u{01FC}";
    public const string LATIN_SMALL_LETTER_AE_WITH_ACUTE                      = "\u{01FD}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_STROKE_AND_ACUTE          = "\u{01FE}";
    public const string LATIN_SMALL_LETTER_O_WITH_STROKE_AND_ACUTE            = "\u{01FF}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_COMMA_BELOW               = "\u{0218}";
    public const string LATIN_SMALL_LETTER_S_WITH_COMMA_BELOW                 = "\u{0219}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_COMMA_BELOW               = "\u{021A}";
    public const string LATIN_SMALL_LETTER_T_WITH_COMMA_BELOW                 = "\u{021B}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_CARON                     = "\u{021E}";
    public const string LATIN_SMALL_LETTER_H_WITH_CARON                       = "\u{021F}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_DOT_ABOVE                 = "\u{0226}";
    public const string LATIN_SMALL_LETTER_A_WITH_DOT_ABOVE                   = "\u{0227}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CEDILLA                   = "\u{0228}";
    public const string LATIN_SMALL_LETTER_E_WITH_CEDILLA                     = "\u{0229}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DIAERESIS_AND_MACRON      = "\u{022A}";
    public const string LATIN_SMALL_LETTER_O_WITH_DIAERESIS_AND_MACRON        = "\u{022B}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_TILDE_AND_MACRON          = "\u{022C}";
    public const string LATIN_SMALL_LETTER_O_WITH_TILDE_AND_MACRON            = "\u{022D}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DOT_ABOVE                 = "\u{022E}";
    public const string LATIN_SMALL_LETTER_O_WITH_DOT_ABOVE                   = "\u{022F}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DOT_ABOVE_AND_MACRON      = "\u{0230}";
    public const string LATIN_SMALL_LETTER_O_WITH_DOT_ABOVE_AND_MACRON        = "\u{0231}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_MACRON                    = "\u{0232}";
    public const string LATIN_SMALL_LETTER_Y_WITH_MACRON                      = "\u{0233}";
    public const string MODIFIER_LETTER_PRIME                                 = "\u{02B9}";
    public const string MODIFIER_LETTER_DOUBLE_PRIME                          = "\u{02BA}";
    public const string MODIFIER_LETTER_TURNED_COMMA                          = "\u{02BB}";
    public const string MODIFIER_LETTER_APOSTROPHE                            = "\u{02BC}";
    public const string MODIFIER_LETTER_CIRCUMFLEX_ACCENT                     = "\u{02C6}";
    public const string CARON                                                 = "\u{02C7}";
    public const string BREVE                                                 = "\u{02D8}";
    public const string DOT_ABOVE                                             = "\u{02D9}";
    public const string RING_ABOVE                                            = "\u{02DA}";
    public const string OGONEK                                                = "\u{02DB}";
    public const string SMALL_TILDE                                           = "\u{02DC}";
    public const string DOUBLE_ACUTE_ACCENT                                   = "\u{02DD}";
    public const string COMBINING_GRAVE_ACCENT                                = "\u{0300}";
    public const string COMBINING_ACUTE_ACCENT                                = "\u{0301}";
    public const string COMBINING_CIRCUMFLEX_ACCENT                           = "\u{0302}";
    public const string COMBINING_TILDE                                       = "\u{0303}";
    public const string COMBINING_MACRON                                      = "\u{0304}";
    public const string COMBINING_OVERLINE                                    = "\u{0305}";
    public const string COMBINING_BREVE                                       = "\u{0306}";
    public const string COMBINING_DOT_ABOVE                                   = "\u{0307}";
    public const string COMBINING_DIAERESIS                                   = "\u{0308}";
    public const string COMBINING_HOOK_ABOVE                                  = "\u{0309}";
    public const string COMBINING_RING_ABOVE                                  = "\u{030A}";
    public const string COMBINING_DOUBLE_ACUTE_ACCENT                         = "\u{030B}";
    public const string COMBINING_CARON                                       = "\u{030C}";
    public const string COMBINING_CANDRABINDU                                 = "\u{0310}";
    public const string COMBINING_COMMA_ABOVE                                 = "\u{0313}";
    public const string COMBINING_COMMA_ABOVE_RIGHT                           = "\u{0315}";
    public const string COMBINING_HORN                                        = "\u{031B}";
    public const string COMBINING_LEFT_HALF_RING_BELOW                        = "\u{031C}";
    public const string COMBINING_DOT_BELOW                                   = "\u{0323}";
    public const string COMBINING_DIAERESIS_BELOW                             = "\u{0324}";
    public const string COMBINING_RING_BELOW                                  = "\u{0325}";
    public const string COMBINING_COMMA_BELOW                                 = "\u{0326}";
    public const string COMBINING_CEDILLA                                     = "\u{0327}";
    public const string COMBINING_OGONEK                                      = "\u{0328}";
    public const string COMBINING_BRIDGE_BELOW                                = "\u{032A}";
    public const string COMBINING_BREVE_BELOW                                 = "\u{032E}";
    public const string COMBINING_LOW_LINE                                    = "\u{0332}";
    public const string COMBINING_DOUBLE_LOW_LINE                             = "\u{0333}";
    public const string COMBINING_SHORT_STROKE_OVERLAY                        = "\u{0335}";
    public const string COMBINING_LONG_STROKE_OVERLAY                         = "\u{0336}";
    public const string COMBINING_SHORT_SOLIDUS_OVERLAY                       = "\u{0338}";
    public const string COMBINING_LONG_SOLIDUS_OVERLAY                        = "\u{0338}";
    public const string COMBINING_DOUBLE_TILDE                                = "\u{0360}";
    public const string COMBINING_DOUBLE_INVERTED_BREVE                       = "\u{0361}";
    public const string GREEK_CAPITAL_LETTER_GAMMA                            = "\u{0393}";
    public const string GREEK_CAPITAL_LETTER_THETA                            = "\u{0398}";
    public const string GREEK_CAPITAL_LETTER_SIGMA                            = "\u{03A3}";
    public const string GREEK_CAPITAL_LETTER_PHI                              = "\u{03A6}";
    public const string GREEK_CAPITAL_LETTER_OMEGA                            = "\u{03A9}";
    public const string GREEK_SMALL_LETTER_ALPHA                              = "\u{03B1}";
    public const string GREEK_SMALL_LETTER_DELTA                              = "\u{03B4}";
    public const string GREEK_SMALL_LETTER_EPSILON                            = "\u{03B5}";
    public const string GREEK_SMALL_LETTER_PI                                 = "\u{03C0}";
    public const string GREEK_SMALL_LETTER_SIGMA                              = "\u{03C3}";
    public const string GREEK_SMALL_LETTER_TAU                                = "\u{03C4}";
    public const string GREEK_SMALL_LETTER_PHI                                = "\u{03C6}";
    public const string CYRILLIC_CAPITAL_LETTER_IO                            = "\u{0401}";
    public const string CYRILLIC_CAPITAL_LETTER_DJE                           = "\u{0402}";
    public const string CYRILLIC_CAPITAL_LETTER_GJE                           = "\u{0403}";
    public const string CYRILLIC_CAPITAL_LETTER_UKRANIAN_IE                   = "\u{0404}";
    public const string CYRILLIC_CAPITAL_LETTER_DZE                           = "\u{0405}";
    public const string CYRILLIC_CAPITAL_LETTER_BYELORUSSIAN_UKRAINIAN_I      = "\u{0406}";
    public const string CYRILLIC_CAPITAL_LETTER_YI                            = "\u{0407}";
    public const string CYRILLIC_CAPITAL_LETTER_JE                            = "\u{0408}";
    public const string CYRILLIC_CAPITAL_LETTER_LJE                           = "\u{0409}";
    public const string CYRILLIC_CAPITAL_LETTER_NJE                           = "\u{040A}";
    public const string CYRILLIC_CAPITAL_LETTER_TSHE                          = "\u{040B}";
    public const string CYRILLIC_CAPITAL_LETTER_KJE                           = "\u{040C}";
    public const string CYRILLIC_CAPITAL_LETTER_SHORT_U                       = "\u{040E}";
    public const string CYRILLIC_CAPITAL_LETTER_DZHE                          = "\u{040F}";
    public const string CYRILLIC_CAPITAL_LETTER_A                             = "\u{0410}";
    public const string CYRILLIC_CAPITAL_LETTER_BE                            = "\u{0411}";
    public const string CYRILLIC_CAPITAL_LETTER_VE                            = "\u{0412}";
    public const string CYRILLIC_CAPITAL_LETTER_GHE                           = "\u{0413}";
    public const string CYRILLIC_CAPITAL_LETTER_DE                            = "\u{0414}";
    public const string CYRILLIC_CAPITAL_LETTER_IE                            = "\u{0415}";
    public const string CYRILLIC_CAPITAL_LETTER_ZHE                           = "\u{0416}";
    public const string CYRILLIC_CAPITAL_LETTER_ZE                            = "\u{0417}";
    public const string CYRILLIC_CAPITAL_LETTER_I                             = "\u{0418}";
    public const string CYRILLIC_CAPITAL_LETTER_SHORT_I                       = "\u{0419}";
    public const string CYRILLIC_CAPITAL_LETTER_KA                            = "\u{041A}";
    public const string CYRILLIC_CAPITAL_LETTER_EL                            = "\u{041B}";
    public const string CYRILLIC_CAPITAL_LETTER_EM                            = "\u{041C}";
    public const string CYRILLIC_CAPITAL_LETTER_EN                            = "\u{041D}";
    public const string CYRILLIC_CAPITAL_LETTER_O                             = "\u{041E}";
    public const string CYRILLIC_CAPITAL_LETTER_PE                            = "\u{041F}";
    public const string CYRILLIC_CAPITAL_LETTER_ER                            = "\u{0420}";
    public const string CYRILLIC_CAPITAL_LETTER_ES                            = "\u{0421}";
    public const string CYRILLIC_CAPITAL_LETTER_TE                            = "\u{0422}";
    public const string CYRILLIC_CAPITAL_LETTER_U                             = "\u{0423}";
    public const string CYRILLIC_CAPITAL_LETTER_EF                            = "\u{0424}";
    public const string CYRILLIC_CAPITAL_LETTER_HA                            = "\u{0425}";
    public const string CYRILLIC_CAPITAL_LETTER_TSE                           = "\u{0426}";
    public const string CYRILLIC_CAPITAL_LETTER_CHE                           = "\u{0427}";
    public const string CYRILLIC_CAPITAL_LETTER_SHA                           = "\u{0428}";
    public const string CYRILLIC_CAPITAL_LETTER_SHCHA                         = "\u{0429}";
    public const string CYRILLIC_CAPITAL_LETTER_HARD_SIGN                     = "\u{042A}";
    public const string CYRILLIC_CAPITAL_LETTER_YERU                          = "\u{042B}";
    public const string CYRILLIC_CAPITAL_LETTER_SOFT_SIGN                     = "\u{042C}";
    public const string CYRILLIC_CAPITAL_LETTER_E                             = "\u{042D}";
    public const string CYRILLIC_CAPITAL_LETTER_YU                            = "\u{042E}";
    public const string CYRILLIC_CAPITAL_LETTER_YA                            = "\u{042F}";
    public const string CYRILLIC_SMALL_LETTER_A                               = "\u{0430}";
    public const string CYRILLIC_SMALL_LETTER_BE                              = "\u{0431}";
    public const string CYRILLIC_SMALL_LETTER_VE                              = "\u{0432}";
    public const string CYRILLIC_SMALL_LETTER_GHE                             = "\u{0433}";
    public const string CYRILLIC_SMALL_LETTER_DE                              = "\u{0434}";
    public const string CYRILLIC_SMALL_LETTER_IE                              = "\u{0435}";
    public const string CYRILLIC_SMALL_LETTER_ZHE                             = "\u{0436}";
    public const string CYRILLIC_SMALL_LETTER_ZE                              = "\u{0437}";
    public const string CYRILLIC_SMALL_LETTER_I                               = "\u{0438}";
    public const string CYRILLIC_SMALL_LETTER_SHORT_I                         = "\u{0439}";
    public const string CYRILLIC_SMALL_LETTER_KA                              = "\u{043A}";
    public const string CYRILLIC_SMALL_LETTER_EL                              = "\u{043B}";
    public const string CYRILLIC_SMALL_LETTER_EM                              = "\u{043C}";
    public const string CYRILLIC_SMALL_LETTER_EN                              = "\u{043D}";
    public const string CYRILLIC_SMALL_LETTER_O                               = "\u{043E}";
    public const string CYRILLIC_SMALL_LETTER_PE                              = "\u{043F}";
    public const string CYRILLIC_SMALL_LETTER_ER                              = "\u{0440}";
    public const string CYRILLIC_SMALL_LETTER_ES                              = "\u{0441}";
    public const string CYRILLIC_SMALL_LETTER_TE                              = "\u{0442}";
    public const string CYRILLIC_SMALL_LETTER_U                               = "\u{0443}";
    public const string CYRILLIC_SMALL_LETTER_EF                              = "\u{0444}";
    public const string CYRILLIC_SMALL_LETTER_HA                              = "\u{0445}";
    public const string CYRILLIC_SMALL_LETTER_TSE                             = "\u{0446}";
    public const string CYRILLIC_SMALL_LETTER_CHE                             = "\u{0447}";
    public const string CYRILLIC_SMALL_LETTER_SHA                             = "\u{0448}";
    public const string CYRILLIC_SMALL_LETTER_SHCHA                           = "\u{0449}";
    public const string CYRILLIC_SMALL_LETTER_HARD_SIGN                       = "\u{044A}";
    public const string CYRILLIC_SMALL_LETTER_YERU                            = "\u{044B}";
    public const string CYRILLIC_SMALL_LETTER_SOFT_SIGN                       = "\u{044C}";
    public const string CYRILLIC_SMALL_LETTER_E                               = "\u{044D}";
    public const string CYRILLIC_SMALL_LETTER_YU                              = "\u{044E}";
    public const string CYRILLIC_SMALL_LETTER_YA                              = "\u{044F}";
    public const string CYRILLIC_SMALL_LETTER_IO                              = "\u{0451}";
    public const string CYRILLIC_SMALL_LETTER_DJE                             = "\u{0452}";
    public const string CYRILLIC_SMALL_LETTER_GJE                             = "\u{0453}";
    public const string CYRILLIC_SMALL_LETTER_UKRANIAN_IE                     = "\u{0454}";
    public const string CYRILLIC_SMALL_LETTER_DZE                             = "\u{0455}";
    public const string CYRILLIC_SMALL_LETTER_BYELORUSSIAN_UKRAINIAN_I        = "\u{0456}";
    public const string CYRILLIC_SMALL_LETTER_YI                              = "\u{0457}";
    public const string CYRILLIC_SMALL_LETTER_JE                              = "\u{0458}";
    public const string CYRILLIC_SMALL_LETTER_LJE                             = "\u{0459}";
    public const string CYRILLIC_SMALL_LETTER_NJE                             = "\u{045A}";
    public const string CYRILLIC_SMALL_LETTER_TSHE                            = "\u{045B}";
    public const string CYRILLIC_SMALL_LETTER_KJE                             = "\u{045C}";
    public const string CYRILLIC_SMALL_LETTER_SHORT_U                         = "\u{045E}";
    public const string CYRILLIC_SMALL_LETTER_DZHE                            = "\u{045F}";
    public const string CYRILLIC_CAPITAL_LETTER_GHE_WITH_UPTURN               = "\u{0490}";
    public const string CYRILLIC_SMALL_LETTER_GHE_WITH_UPTURN                 = "\u{0491}";
    public const string ARABIC_LETTER_HAMZA                                   = "\u{0621}";
    public const string ARABIC_LETTER_ALEF                                    = "\u{0627}";
    public const string ARABIC_LETTER_BEH                                     = "\u{0628}";
    public const string ARABIC_LETTER_TEH_MARBUTA                             = "\u{0629}";
    public const string ARABIC_LETTER_TEH                                     = "\u{062A}";
    public const string ARABIC_LETTER_THEH                                    = "\u{062B}";
    public const string ARABIC_LETTER_JEEM                                    = "\u{062C}";
    public const string ARABIC_LETTER_HAH                                     = "\u{062D}";
    public const string ARABIC_LETTER_KHAH                                    = "\u{062E}";
    public const string ARABIC_LETTER_DAL                                     = "\u{062F}";
    public const string ARABIC_LETTER_THAL                                    = "\u{0630}";
    public const string ARABIC_LETTER_REH                                     = "\u{0631}";
    public const string ARABIC_LETTER_ZAIN                                    = "\u{0632}";
    public const string ARABIC_LETTER_SEEN                                    = "\u{0633}";
    public const string ARABIC_LETTER_SHEEN                                   = "\u{0634}";
    public const string ARABIC_LETTER_SAD                                     = "\u{0635}";
    public const string ARABIC_LETTER_DAD                                     = "\u{0636}";
    public const string ARABIC_LETTER_TAH                                     = "\u{0637}";
    public const string ARABIC_LETTER_ZAH                                     = "\u{0638}";
    public const string ARABIC_LETTER_AIN                                     = "\u{0639}";
    public const string ARABIC_LETTER_GHAIN                                   = "\u{063A}";
    public const string ARABIC_LETTER_FEH                                     = "\u{0641}";
    public const string ARABIC_LETTER_QAF                                     = "\u{0642}";
    public const string ARABIC_LETTER_KAF                                     = "\u{0643}";
    public const string ARABIC_LETTER_LAM                                     = "\u{0644}";
    public const string ARABIC_LETTER_MEEM                                    = "\u{0645}";
    public const string ARABIC_LETTER_NOON                                    = "\u{0646}";
    public const string ARABIC_LETTER_HEH                                     = "\u{0647}";
    public const string ARABIC_LETTER_WAW                                     = "\u{0648}";
    public const string ARABIC_LETTER_ALEF_MAKSURA                            = "\u{0649}";
    public const string ARABIC_LETTER_YEH                                     = "\u{064A}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_RING_BELOW                = "\u{1E00}";
    public const string LATIN_SMALL_LETTER_A_WITH_RING_BELOW                  = "\u{1E01}";
    public const string LATIN_CAPITAL_LETTER_B_WITH_DOT_ABOVE                 = "\u{1E02}";
    public const string LATIN_SMALL_LETTER_B_WITH_DOT_ABOVE                   = "\u{1E03}";
    public const string LATIN_CAPITAL_LETTER_B_WITH_DOT_BELOW                 = "\u{1E04}";
    public const string LATIN_SMALL_LETTER_B_WITH_DOT_BELOW                   = "\u{1E05}";
    public const string LATIN_CAPITAL_LETTER_C_WITH_CEDILLA_AND_ACUTE         = "\u{1E08}";
    public const string LATIN_SMALL_LETTER_C_WITH_CEDILLA_AND_ACUTE           = "\u{1E09}";
    public const string LATIN_CAPITAL_LETTER_D_WITH_DOT_ABOVE                 = "\u{1E0A}";
    public const string LATIN_SMALL_LETTER_D_WITH_DOT_ABOVE                   = "\u{1E0B}";
    public const string LATIN_CAPITAL_LETTER_D_WITH_DOT_BELOW                 = "\u{1E0C}";
    public const string LATIN_SMALL_LETTER_D_WITH_DOT_BELOW                   = "\u{1E0D}";
    public const string LATIN_CAPITAL_LETTER_SHARP_S                          = "\u{1E9E}";
    public const string LATIN_CAPITAL_LETTER_D_WITH_CEDILLA                   = "\u{1E10}";
    public const string LATIN_SMALL_LETTER_D_WITH_CEDILLA                     = "\u{1E11}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_MACRON_AND_GRAVE          = "\u{1E14}";
    public const string LATIN_SMALL_LETTER_E_WITH_MACRON_AND_GRAVE            = "\u{1E15}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_MACRON_AND_ACUTE          = "\u{1E16}";
    public const string LATIN_SMALL_LETTER_E_WITH_MACRON_AND_ACUTE            = "\u{1E17}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CEDILLA_AND_BREVE         = "\u{1E1C}";
    public const string LATIN_SMALL_LETTER_E_WITH_CEDILLA_AND_BREVE           = "\u{1E1D}";
    public const string LATIN_CAPITAL_LETTER_F_WITH_DOT_ABOVE                 = "\u{1E1E}";
    public const string LATIN_SMALL_LETTER_F_WITH_DOT_ABOVE                   = "\u{1E1F}";
    public const string LATIN_CAPITAL_LETTER_G_WITH_MACRON                    = "\u{1E20}";
    public const string LATIN_SMALL_LETTER_G_WITH_MACRON                      = "\u{1E21}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_DOT_ABOVE                 = "\u{1E22}";
    public const string LATIN_SMALL_LETTER_H_WITH_DOT_ABOVE                   = "\u{1E23}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_DOT_BELOW                 = "\u{1E24}";
    public const string LATIN_SMALL_LETTER_H_WITH_DOT_BELOW                   = "\u{1E25}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_DIAERESIS                 = "\u{1E26}";
    public const string LATIN_SMALL_LETTER_H_WITH_DIAERESIS                   = "\u{1E27}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_CEDILLA                   = "\u{1E28}";
    public const string LATIN_SMALL_LETTER_H_WITH_CEDILLA                     = "\u{1E29}";
    public const string LATIN_CAPITAL_LETTER_H_WITH_BREVE_BELOW               = "\u{1E2A}";
    public const string LATIN_SMALL_LETTER_H_WITH_BREVE_BELOW                 = "\u{1E2B}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_DIAERESIS_AND_ACUTE       = "\u{1E2E}";
    public const string LATIN_SMALL_LETTER_I_WITH_DIAERESIS_AND_ACUTE         = "\u{1E2F}";
    public const string LATIN_CAPITAL_LETTER_K_WITH_ACUTE                     = "\u{1E30}";
    public const string LATIN_SMALL_LETTER_K_WITH_ACUTE                       = "\u{1E31}";
    public const string LATIN_CAPITAL_LETTER_K_WITH_DOT_BELOW                 = "\u{1E32}";
    public const string LATIN_SMALL_LETTER_K_WITH_DOT_BELOW                   = "\u{1E33}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_DOT_BELOW                 = "\u{1E36}";
    public const string LATIN_SMALL_LETTER_L_WITH_DOT_BELOW                   = "\u{1E37}";
    public const string LATIN_CAPITAL_LETTER_L_WITH_DOT_BELOW_AND_MACRON      = "\u{1E38}";
    public const string LATIN_SMALL_LETTER_L_WITH_DOT_BELOW_AND_MACRON        = "\u{1E39}";
    public const string LATIN_CAPITAL_LETTER_M_WITH_ACUTE                     = "\u{1E3E}";
    public const string LATIN_SMALL_LETTER_M_WITH_ACUTE                       = "\u{1E3F}";
    public const string LATIN_CAPITAL_LETTER_M_WITH_DOT_ABOVE                 = "\u{1E40}";
    public const string LATIN_SMALL_LETTER_M_WITH_DOT_ABOVE                   = "\u{1E41}";
    public const string LATIN_CAPITAL_LETTER_M_WITH_DOT_BELOW                 = "\u{1E42}";
    public const string LATIN_SMALL_LETTER_M_WITH_DOT_BELOW                   = "\u{1E43}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_DOT_ABOVE                 = "\u{1E44}";
    public const string LATIN_SMALL_LETTER_N_WITH_DOT_ABOVE                   = "\u{1E45}";
    public const string LATIN_CAPITAL_LETTER_N_WITH_DOT_BELOW                 = "\u{1E46}";
    public const string LATIN_SMALL_LETTER_N_WITH_DOT_BELOW                   = "\u{1E47}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_TILDE_AND_ACUTE           = "\u{1E4C}";
    public const string LATIN_SMALL_LETTER_O_WITH_TILDE_AND_ACUTE             = "\u{1E4D}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_TILDE_AND_DIAERESIS       = "\u{1E4E}";
    public const string LATIN_SMALL_LETTER_O_WITH_TILDE_AND_DIAERESIS         = "\u{1E4F}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_MACRON_AND_GRAVE          = "\u{1E50}";
    public const string LATIN_SMALL_LETTER_O_WITH_MACRON_AND_GRAVE            = "\u{1E51}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_MACRON_AND_ACUTE          = "\u{1E52}";
    public const string LATIN_SMALL_LETTER_O_WITH_MACRON_AND_ACUTE            = "\u{1E53}";
    public const string LATIN_CAPITAL_LETTER_P_WITH_ACUTE                     = "\u{1E54}";
    public const string LATIN_SMALL_LETTER_P_WITH_ACUTE                       = "\u{1E55}";
    public const string LATIN_CAPITAL_LETTER_P_WITH_DOT_ABOVE                 = "\u{1E56}";
    public const string LATIN_SMALL_LETTER_P_WITH_DOT_ABOVE                   = "\u{1E57}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_DOT_ABOVE                 = "\u{1E58}";
    public const string LATIN_SMALL_LETTER_R_WITH_DOT_ABOVE                   = "\u{1E59}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_DOT_BELOW                 = "\u{1E5A}";
    public const string LATIN_SMALL_LETTER_R_WITH_DOT_BELOW                   = "\u{1E5B}";
    public const string LATIN_CAPITAL_LETTER_R_WITH_DOT_BELOW_AND_MACRON      = "\u{1E5C}";
    public const string LATIN_SMALL_LETTER_R_WITH_DOT_BELOW_AND_MACRON        = "\u{1E5D}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_DOT_ABOVE                 = "\u{1E60}";
    public const string LATIN_SMALL_LETTER_S_WITH_DOT_ABOVE                   = "\u{1E61}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_DOT_BELOW                 = "\u{1E62}";
    public const string LATIN_SMALL_LETTER_S_WITH_DOT_BELOW                   = "\u{1E63}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_ACUTE_AND_DOT_ABOVE       = "\u{1E64}";
    public const string LATIN_SMALL_LETTER_S_WITH_ACUTE_AND_DOT_ABOVE         = "\u{1E65}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_CARON_AND_DOT_ABOVE       = "\u{1E66}";
    public const string LATIN_SMALL_LETTER_S_WITH_CARON_AND_DOT_ABOVE         = "\u{1E67}";
    public const string LATIN_CAPITAL_LETTER_S_WITH_DOT_BELOW_AND_DOT_ABOVE   = "\u{1E68}";
    public const string LATIN_SMALL_LETTER_S_WITH_DOT_BELOW_AND_DOT_ABOVE     = "\u{1E69}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_DOT_ABOVE                 = "\u{1E6A}";
    public const string LATIN_SMALL_LETTER_T_WITH_DOT_ABOVE                   = "\u{1E6B}";
    public const string LATIN_CAPITAL_LETTER_T_WITH_DOT_BELOW                 = "\u{1E6C}";
    public const string LATIN_SMALL_LETTER_T_WITH_DOT_BELOW                   = "\u{1E6D}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DIAERESIS_BELOW           = "\u{1E72}";
    public const string LATIN_SMALL_LETTER_U_WITH_DIAERESIS_BELOW             = "\u{1E73}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_TILDE_AND_ACUTE           = "\u{1E78}";
    public const string LATIN_SMALL_LETTER_U_WITH_TILDE_AND_ACUTE             = "\u{1E79}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_MACRON_AND_DIAERESIS      = "\u{1E7A}";
    public const string LATIN_SMALL_LETTER_U_WITH_MACRON_AND_DIAERESIS        = "\u{1E7B}";
    public const string LATIN_CAPITAL_LETTER_V_WITH_TILDE                     = "\u{1E7C}";
    public const string LATIN_SMALL_LETTER_V_WITH_TILDE                       = "\u{1E7D}";
    public const string LATIN_CAPITAL_LETTER_V_WITH_DOT_BELOW                 = "\u{1E7E}";
    public const string LATIN_SMALL_LETTER_V_WITH_DOT_BELOW                   = "\u{1E7F}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_GRAVE                     = "\u{1E80}";
    public const string LATIN_SMALL_LETTER_W_WITH_GRAVE                       = "\u{1E81}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_ACUTE                     = "\u{1E82}";
    public const string LATIN_SMALL_LETTER_W_WITH_ACUTE                       = "\u{1E83}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_DIAERESIS                 = "\u{1E84}";
    public const string LATIN_SMALL_LETTER_W_WITH_DIAERESIS                   = "\u{1E85}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_DOT_ABOVE                 = "\u{1E86}";
    public const string LATIN_SMALL_LETTER_W_WITH_DOT_ABOVE                   = "\u{1E87}";
    public const string LATIN_CAPITAL_LETTER_W_WITH_DOT_BELOW                 = "\u{1E88}";
    public const string LATIN_SMALL_LETTER_W_WITH_DOT_BELOW                   = "\u{1E89}";
    public const string LATIN_CAPITAL_LETTER_X_WITH_DOT_ABOVE                 = "\u{1E8A}";
    public const string LATIN_SMALL_LETTER_X_WITH_DOT_ABOVE                   = "\u{1E8B}";
    public const string LATIN_CAPITAL_LETTER_X_WITH_DIAERESIS                 = "\u{1E8C}";
    public const string LATIN_SMALL_LETTER_X_WITH_DIAERESIS                   = "\u{1E8D}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_DOT_ABOVE                 = "\u{1E8E}";
    public const string LATIN_SMALL_LETTER_Y_WITH_DOT_ABOVE                   = "\u{1E8F}";
    public const string LATIN_CAPITAL_LETTER_Z_WITH_CIRCUMFLEX                = "\u{1E90}";
    public const string LATIN_SMALL_LETTER_Z_WITH_CIRCUMFLEX                  = "\u{1E91}";
    public const string LATIN_CAPITAL_LETTER_Z_WITH_DOT_BELOW                 = "\u{1E92}";
    public const string LATIN_SMALL_LETTER_Z_WITH_DOT_BELOW                   = "\u{1E93}";
    public const string LATIN_SMALL_LETTER_T_WITH_DIAERESIS                   = "\u{1E97}";
    public const string LATIN_SMALL_LETTER_W_WITH_RING_ABOVE                  = "\u{1E98}";
    public const string LATIN_SMALL_LETTER_Y_WITH_RING_ABOVE                  = "\u{1E99}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_DOT_BELOW                 = "\u{1EA0}";
    public const string LATIN_SMALL_LETTER_A_WITH_DOT_BELOW                   = "\u{1EA1}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_HOOK_ABOVE                = "\u{1EA2}";
    public const string LATIN_SMALL_LETTER_A_WITH_HOOK_ABOVE                  = "\u{1EA3}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX_AND_ACUTE      = "\u{1EA4}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX_AND_ACUTE        = "\u{1EA5}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX_AND_GRAVE      = "\u{1EA6}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX_AND_GRAVE        = "\u{1EA7}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX_AND_HOOK_ABOVE = "\u{1EA8}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX_AND_HOOK_ABOVE   = "\u{1EA9}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX_AND_TILDE      = "\u{1EAA}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX_AND_TILDE        = "\u{1EAB}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_CIRCUMFLEX_AND_DOT_BELOW  = "\u{1EAC}";
    public const string LATIN_SMALL_LETTER_A_WITH_CIRCUMFLEX_AND_DOT_BELOW    = "\u{1EAD}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE_AND_ACUTE           = "\u{1EAE}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE_AND_ACUTE             = "\u{1EAF}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE_AND_GRAVE           = "\u{1EB0}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE_AND_GRAVE             = "\u{1EB1}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE_AND_HOOK_ABOVE      = "\u{1EB2}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE_AND_HOOK_ABOVE        = "\u{1EB3}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE_AND_TILDE           = "\u{1EB4}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE_AND_TILDE             = "\u{1EB5}";
    public const string LATIN_CAPITAL_LETTER_A_WITH_BREVE_AND_DOT_BELOW       = "\u{1EB6}";
    public const string LATIN_SMALL_LETTER_A_WITH_BREVE_AND_DOT_BELOW         = "\u{1EB7}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_DOT_BELOW                 = "\u{1EB8}";
    public const string LATIN_SMALL_LETTER_E_WITH_DOT_BELOW                   = "\u{1EB9}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_HOOK_ABOVE                = "\u{1EBA}";
    public const string LATIN_SMALL_LETTER_E_WITH_HOOK_ABOVE                  = "\u{1EBB}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_TILDE                     = "\u{1EBC}";
    public const string LATIN_SMALL_LETTER_E_WITH_TILDE                       = "\u{1EBD}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX_AND_ACUTE      = "\u{1EBE}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX_AND_ACUTE        = "\u{1EBF}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX_AND_GRAVE      = "\u{1EC0}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX_AND_GRAVE        = "\u{1EC1}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX_AND_HOOK_ABOVE = "\u{1EC2}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX_AND_HOOK_ABOVE   = "\u{1EC3}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX_AND_TILDE      = "\u{1EC4}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX_AND_TILDE        = "\u{1EC5}";
    public const string LATIN_CAPITAL_LETTER_E_WITH_CIRCUMFLEX_AND_DOT_BELOW  = "\u{1EC6}";
    public const string LATIN_SMALL_LETTER_E_WITH_CIRCUMFLEX_AND_DOT_BELOW    = "\u{1EC7}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_HOOK_ABOVE                = "\u{1EC8}";
    public const string LATIN_SMALL_LETTER_I_WITH_HOOK_ABOVE                  = "\u{1EC9}";
    public const string LATIN_CAPITAL_LETTER_I_WITH_DOT_BELOW                 = "\u{1ECA}";
    public const string LATIN_SMALL_LETTER_I_WITH_DOT_BELOW                   = "\u{1ECB}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_DOT_BELOW                 = "\u{1ECC}";
    public const string LATIN_SMALL_LETTER_O_WITH_DOT_BELOW                   = "\u{1ECD}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_HOOK_ABOVE                = "\u{1ECE}";
    public const string LATIN_SMALL_LETTER_O_WITH_HOOK_ABOVE                  = "\u{1ECF}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX_AND_ACUTE      = "\u{1ED0}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX_AND_ACUTE        = "\u{1ED1}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX_AND_GRAVE      = "\u{1ED2}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX_AND_GRAVE        = "\u{1ED3}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX_AND_HOOK_ABOVE = "\u{1ED4}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX_AND_HOOK_ABOVE   = "\u{1ED5}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX_AND_TILDE      = "\u{1ED6}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX_AND_TILDE        = "\u{1ED7}";
    public const string LATIN_CAPITAL_LETTER_O_WITH_CIRCUMFLEX_AND_DOT_BELOW  = "\u{1ED8}";
    public const string LATIN_SMALL_LETTER_O_WITH_CIRCUMFLEX_AND_DOT_BELOW    = "\u{1ED9}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_DOT_BELOW                 = "\u{1EE4}";
    public const string LATIN_SMALL_LETTER_U_WITH_DOT_BELOW                   = "\u{1EE5}";
    public const string LATIN_CAPITAL_LETTER_U_WITH_HOOK_ABOVE                = "\u{1EE6}";
    public const string LATIN_SMALL_LETTER_U_WITH_HOOK_ABOVE                  = "\u{1EE7}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_GRAVE                     = "\u{1EF2}";
    public const string LATIN_SMALL_LETTER_Y_WITH_GRAVE                       = "\u{1EF3}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_DOT_BELOW                 = "\u{1EF4}";
    public const string LATIN_SMALL_LETTER_Y_WITH_DOT_BELOW                   = "\u{1EF5}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_HOOK_ABOVE                = "\u{1EF6}";
    public const string LATIN_SMALL_LETTER_Y_WITH_HOOK_ABOVE                  = "\u{1EF7}";
    public const string LATIN_CAPITAL_LETTER_Y_WITH_TILDE                     = "\u{1EF8}";
    public const string LATIN_SMALL_LETTER_Y_WITH_TILDE                       = "\u{1EF9}";
    public const string ZERO_WIDTH_NON_JOINER                                 = "\u{200C}";
    public const string ZERO_WIDTH_JOINER                                     = "\u{200D}";
    public const string EN_DASH                                               = "\u{2013}";
    public const string EM_DASH                                               = "\u{2014}";
    public const string DOUBLE_LOW_LINE                                       = "\u{2017}";
    public const string LEFT_SINGLE_QUOTATION_MARK                            = "\u{2018}";
    public const string RIGHT_SINGLE_QUOTATION_MARK                           = "\u{2019}";
    public const string SINGLE_LOW_9_QUOTATION_MARK                           = "\u{201A}";
    public const string LEFT_DOUBLE_QUOTATION_MARK                            = "\u{201C}";
    public const string RIGHT_DOUBLE_QUOTATION_MARK                           = "\u{201D}";
    public const string DOUBLE_LOW_9_QUOTATION_MARK                           = "\u{201E}";
    public const string DAGGER                                                = "\u{2020}";
    public const string DOUBLE_DAGGER                                         = "\u{2021}";
    public const string BULLET                                                = "\u{2022}";
    public const string HORIZONTAL_ELLIPSIS                                   = "\u{2026}";
    public const string PER_MILLE_SIGN                                        = "\u{2030}";
    public const string SINGLE_LEFT_POINTING_ANGLE_QUOTATION_MARK             = "\u{2039}";
    public const string SINGLE_RIGHT_POINTING_ANGLE_QUOTATION_MARK            = "\u{203A}";
    public const string FRACTION_SLASH                                        = "\u{2044}";
    public const string SUPERSCRIPT_LATIN_SMALL_LETTER_N                      = "\u{207F}";
    public const string PESETA_SIGN                                           = "\u{20A7}";
    public const string EURO_SIGN                                             = "\u{20AC}";
    public const string SCRIPT_SMALL_L                                        = "\u{2113}";
    public const string NUMERO_SIGN                                           = "\u{2116}";
    public const string SOUND_RECORDING_COPYRIGHT                             = "\u{2117}";
    public const string TRADE_MARK_SIGN                                       = "\u{2122}";
    public const string PARTIAL_DIFFERENTIAL                                  = "\u{2202}";
    public const string INCREMENT                                             = "\u{2206}";
    public const string N_ARY_PRODUCT                                         = "\u{220F}";
    public const string N_ARY_SUMMATION                                       = "\u{2211}";
    public const string BULLET_OPERATOR                                       = "\u{2219}";
    public const string SQUARE_ROOT                                           = "\u{221A}";
    public const string INFINITY                                              = "\u{221E}";
    public const string INTERSECTION                                          = "\u{2229}";
    public const string INTEGRAL                                              = "\u{222B}";
    public const string ALMOST_EQUAL_TO                                       = "\u{2248}";
    public const string NOT_EQUAL_TO                                          = "\u{2260}";
    public const string IDENTICAL_TO                                          = "\u{2261}";
    public const string LESS_THAN_OR_EQUAL_TO                                 = "\u{2264}";
    public const string GREATER_THAN_OR_EQUAL_TO                              = "\u{2265}";
    public const string REVERSED_NOT_SIGN                                     = "\u{2310}";
    public const string TOP_HALF_INTEGRAL                                     = "\u{2320}";
    public const string BOTTOM_HALF_INTEGRAL                                  = "\u{2321}";
    public const string BOX_DRAWINGS_LIGHT_HORIZONTAL                         = "\u{2500}";
    public const string BOX_DRAWINGS_LIGHT_VERTICAL                           = "\u{2502}";
    public const string BOX_DRAWINGS_LIGHT_DOWN_AND_RIGHT                     = "\u{250C}";
    public const string BOX_DRAWINGS_LIGHT_DOWN_AND_LEFT                      = "\u{2510}";
    public const string BOX_DRAWINGS_LIGHT_UP_AND_LEFT                        = "\u{2518}";
    public const string BOX_DRAWINGS_LIGHT_UP_AND_RIGHT                       = "\u{2514}";
    public const string BOX_DRAWINGS_LIGHT_VERTICAL_AND_RIGHT                 = "\u{251C}";
    public const string BOX_DRAWINGS_LIGHT_VERTICAL_AND_LEFT                  = "\u{2524}";
    public const string BOX_DRAWINGS_LIGHT_DOWN_AND_HORIZONTAL                = "\u{252C}";
    public const string BOX_DRAWINGS_LIGHT_UP_AND_HORIZONTAL                  = "\u{2534}";
    public const string BOX_DRAWINGS_LIGHT_VERTICAL_AND_HORIZONTAL            = "\u{253C}";
    public const string BOX_DRAWINGS_DOUBLE_HORIZONTAL                        = "\u{2550}";
    public const string BOX_DRAWINGS_DOUBLE_VERTICAL                          = "\u{2551}";
    public const string BOX_DRAWINGS_DOWN_SINGLE_AND_RIGHT_DOUBLE             = "\u{2552}";
    public const string BOX_DRAWINGS_DOWN_DOUBLE_AND_RIGHT_SINGLE             = "\u{2553}";
    public const string BOX_DRAWINGS_DOUBLE_DOWN_AND_RIGHT                    = "\u{2554}";
    public const string BOX_DRAWINGS_DOWN_SINGLE_AND_LEFT_DOUBLE              = "\u{2555}";
    public const string BOX_DRAWINGS_DOWN_DOUBLE_AND_LEFT_SINGLE              = "\u{2556}";
    public const string BOX_DRAWINGS_DOUBLE_DOWN_AND_LEFT                     = "\u{2557}";
    public const string BOX_DRAWINGS_UP_SINGLE_AND_RIGHT_DOUBLE               = "\u{2558}";
    public const string BOX_DRAWINGS_UP_DOUBLE_AND_RIGHT_SINGLE               = "\u{2559}";
    public const string BOX_DRAWINGS_DOUBLE_UP_AND_RIGHT                      = "\u{255A}";
    public const string BOX_DRAWINGS_UP_SINGLE_AND_LEFT_DOUBLE                = "\u{255B}";
    public const string BOX_DRAWINGS_UP_DOUBLE_AND_LEFT_SINGLE                = "\u{255C}";
    public const string BOX_DRAWINGS_DOUBLE_UP_AND_LEFT                       = "\u{255D}";
    public const string BOX_DRAWINGS_VERTICAL_SINGLE_AND_RIGHT_DOUBLE         = "\u{255E}";
    public const string BOX_DRAWINGS_VERTICAL_DOUBLE_AND_RIGHT_SINGLE         = "\u{255F}";
    public const string BOX_DRAWINGS_DOUBLE_VERTICAL_AND_RIGHT                = "\u{2560}";
    public const string BOX_DRAWINGS_VERTICAL_SINGLE_AND_LEFT_DOUBLE          = "\u{2561}";
    public const string BOX_DRAWINGS_VERTICAL_DOUBLE_AND_LEFT_SINGLE          = "\u{2562}";
    public const string BOX_DRAWINGS_DOUBLE_VERTICAL_AND_LEFT                 = "\u{2563}";
    public const string BOX_DRAWINGS_DOWN_SINGLE_AND_HORIZONTAL_DOUBLE        = "\u{2564}";
    public const string BOX_DRAWINGS_DOWN_DOUBLE_AND_HORIZONTAL_SINGLE        = "\u{2565}";
    public const string BOX_DRAWINGS_DOUBLE_DOWN_AND_HORIZONTAL               = "\u{2566}";
    public const string BOX_DRAWINGS_UP_SINGLE_AND_HORIZONTAL_DOUBLE          = "\u{2567}";
    public const string BOX_DRAWINGS_UP_DOUBLE_AND_HORIZONTAL_SINGLE          = "\u{2568}";
    public const string BOX_DRAWINGS_BOX_DRAWINGS_DOUBLE_UP_AND_HORIZONTAL    = "\u{2569}";
    public const string BOX_DRAWINGS_VERTICAL_SINGLE_AND_HORIZONTAL_DOUBLE    = "\u{256A}";
    public const string BOX_DRAWINGS_VERTICAL_DOUBLE_AND_HORIZONTAL_SINGLE    = "\u{256B}";
    public const string BOX_DRAWINGS_DOUBLE_VERTICAL_AND_HORIZONTAL           = "\u{256C}";
    public const string UPPER_HALF_BLOCK                                      = "\u{2580}";
    public const string LOWER_HALF_BLOCK                                      = "\u{2584}";
    public const string FULL_BLOCK                                            = "\u{2588}";
    public const string LEFT_HALF_BLOCK                                       = "\u{258C}";
    public const string RIGHT_HALF_BLOCK                                      = "\u{2590}";
    public const string LIGHT_SHADE                                           = "\u{2591}";
    public const string MEDIUM_SHADE                                          = "\u{2592}";
    public const string DARK_SHADE                                            = "\u{2593}";
    public const string BLACK_SQUARE                                          = "\u{25A0}";
    public const string WHITE_SQUARE                                          = "\u{25A1}";
    public const string LOZENGE                                               = "\u{25CA}";
    public const string MUSIC_FLAT_SIGN                                       = "\u{266D}";
    public const string MUSIC_SHARP_SIGN                                      = "\u{266F}";
    public const string LATIN_SMALL_LIGATURE_FI                               = "\u{FB01}";
    public const string LATIN_SMALL_LIGATURE_FL                               = "\u{FB02}";
    public const string BYTE_ORDER_MARK                                       = "\u{FEFF}";
    public const string REPLACEMENT_CHARACTER                                 = "\u{FFFD}";

    /**
     * Convert text from (potentially invalid) UTF-8 to UTF-8.
     *
     * @param string $text
     *
     * @return string
     */
    public function fromUtf8(string $text): string
    {
        if (preg_match('//u', $text) === false) {
            // Not UTF8?
            mb_substitute_character(0xFFFD);

            return mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        }

        return $text;
    }

    /**
     * Convert text from (potentially invalid) UTF-8 to UTF-8.
     *
     * @param string $text
     *
     * @return string
     */
    public function toUtf8(string $text): string
    {
        return $this->fromUtf8($text);
    }

    /**
     * Create a UTF8 character from a code.
     *
     * @param int $code
     *
     * @return string
     */
    public static function chr(int $code): string
    {
        if ($code < 0 || $code > 0x1FFFFF) {
            throw new InvalidArgumentException((string)$code);
        }

        if ($code <= 0x7F) {
            return chr($code);
        }

        if ($code <= 0x7FF) {
            return
                chr(($code >> 6) + 0xC0) .
                chr(($code & 0x3F) + 0x80);
        }

        if ($code <= 0xFFFF) {
            return
                chr(($code >> 12) + 0xE0) .
                chr((($code >> 6) & 0x3F) + 0x80) .
                chr(($code & 0x3F) + 0x80);
        }

        return
            chr(($code >> 18) + 0xF0) .
            chr((($code >> 12) & 0x3F) + 0x80) .
            chr((($code >> 6) & 0x3F) + 0x80) .
            chr(($code & 0x3F) + 0x80);
    }
}

# -*- coding: utf-8 -*-
import os
from subprocess import call

urls = [
    # "https://ganjoor.net/ferdousi/shahname/aghaz/sh1/", # 12
    # "https://ganjoor.net/ferdousi/shahname/qmars/sh1/", #2
    # "https://ganjoor.net/ferdousi/shahname/hushang/sh1/", #3
    # "https://ganjoor.net/ferdousi/shahname/tahmoores/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/jamshid/sh1/", #4
    # "https://ganjoor.net/ferdousi/shahname/zahak/sh1/", #12
    # "https://ganjoor.net/ferdousi/shahname/fereydoon/sh1/", #20
    # "https://ganjoor.net/ferdousi/shahname/manoochehr/sh1/", #28
    # "https://ganjoor.net/ferdousi/shahname/nozar/sh1/", #13
    # "https://ganjoor.net/ferdousi/shahname/zutahmasb/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/garshasp/sh1/", #5
    # "https://ganjoor.net/ferdousi/shahname/kqobad/sh1/", #5
    # "https://ganjoor.net/ferdousi/shahname/kkavoos/sh1/", #17
    # "https://ganjoor.net/ferdousi/shahname/hamavaran/sh1/", #12
    # "https://ganjoor.net/ferdousi/shahname/sohrab/sh1/", #21
    # "https://ganjoor.net/ferdousi/shahname/siavosh/sh1/", #22
    # "https://ganjoor.net/ferdousi/shahname/kkhosro/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/forood/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/kamoos/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/khaghan/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/akvan/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/bizhan/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/12rokh/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/mahmood/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/lohrasp/sh1/", #17
    # "https://ganjoor.net/ferdousi/shahname/goshtasp/sh1/", #33
    # "https://ganjoor.net/ferdousi/shahname/7esfandyar/sh1/", #15
    # "https://ganjoor.net/ferdousi/shahname/esfandyar/sh1/", #31
    # "https://ganjoor.net/ferdousi/shahname/shqad/sh1/", #8
    # "https://ganjoor.net/ferdousi/shahname/bahman/sh1/", #5
    # "https://ganjoor.net/ferdousi/shahname/homa/sh1/", #7
    # "https://ganjoor.net/ferdousi/shahname/darab/sh1/", #4
    # "https://ganjoor.net/ferdousi/shahname/dara/sh1/", #10
    # "https://ganjoor.net/ferdousi/shahname/eskandar/sh1/", #47
    # "https://ganjoor.net/ferdousi/shahname/ashkanian/sh1/", #21
    # "https://ganjoor.net/ferdousi/shahname/ardeshir/sh1/", #14
    # "https://ganjoor.net/ferdousi/shahname/shapoor/sh1/", #3
    # "https://ganjoor.net/ferdousi/shahname/oormazd/sh1/", #2
    # "https://ganjoor.net/ferdousi/shahname/bahram/sh1/", #2
    # "https://ganjoor.net/ferdousi/shahname/bahram19/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/bahramian/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/nrsi/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/oorner/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/zolaktaf/sh1/", #16
    # "https://ganjoor.net/ferdousi/shahname/nekookar/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/shapoor3/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/bahpoor/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/bezehgar/sh1/", #17
    # "https://ganjoor.net/ferdousi/shahname/bahgoor/sh1/", #46
    # "https://ganjoor.net/ferdousi/shahname/yazdgerd/sh1/", #4
    # "https://ganjoor.net/ferdousi/shahname/qobad/sh1/", #2
    # "https://ganjoor.net/ferdousi/shahname/anooshirvan/sh1/", #12
    # "https://ganjoor.net/ferdousi/shahname/hormozd/sh1/", #10
    # "https://ganjoor.net/ferdousi/shahname/parviz/sh1/", #76
    # "https://ganjoor.net/ferdousi/shahname/shirooye/sh1/", #6
    # "https://ganjoor.net/ferdousi/shahname/ardeshiroo/sh1/", #2
    # "https://ganjoor.net/ferdousi/shahname/farayeen/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/pooran/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/azarmdokht/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/farrokh/sh1/", #1
    # "https://ganjoor.net/ferdousi/shahname/yazdgerd3/sh1/", #17
    # ["https://ganjoor.net/saadi/boostan/niyayesh/sh", 6, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab1/sh", 41, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab2/sh", 30, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab3/sh", 25, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab4/sh", 28, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab5/sh", 15, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab6/sh", 15, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab7/sh", 29, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab8/sh", 15, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab9/sh", 22, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/boostan/bab10/sh", 4, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/saadi/golestan/dibache", 1, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab1/sh", 41, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab2/sh", 46, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab3/sh", 28, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab4/sh", 14, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab5/sh", 20, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab6/sh", 9, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/golestan/gbab7/sh", 19, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/ghazal2/sh", 65, "ghazal", True, "غزل"],
    # ["https://ganjoor.net/saadi/mavaez/ghasides/sh", 61, "ghaside", False, "قصیده"],
    # ["https://ganjoor.net/saadi/mavaez/marasi/sh", 7, "mix", False, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/ghete2/sh", 227, "ghate", True, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/masnaviat/sh", 46, "masnavi", True, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/robaees2/sh", 56, "robaee", False, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/mofradat/sh", 80, "mofrad", False, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/mo3at", 1, "mosalas", False, "بخش"],
    # ["https://ganjoor.net/saadi/mavaez/arabi/sh", 23, "arabi", False, "بخش"],
    # ["https://ganjoor.net/vahshi/divanv/ghazalv/sh", 397, "ghazal", True, "غزل"],
    # ["https://ganjoor.net/vahshi/divanv/ghasidev/sh", 41, "ghaside", False, "قصیده"],
    # ["https://ganjoor.net/vahshi/divanv/ghete-vahshi/sh", 43, "ghate", False, "قطعه"],
    # ["https://ganjoor.net/vahshi/divanv/masnaviatv/sh", 8, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/vahshi/divanv/tarjeeat-vahshi/sh1", 1, "tarjee", False, "ترجیع بند"],
    # ["https://ganjoor.net/vahshi/divanv/tarkibatv/sh", 11, "tarkib", False, "ترکیب‌بند"],
    # ["https://ganjoor.net/vahshi/divanv/robaee-vahshi/sh", 66, "robaee", True, "ترکیب‌بند"],
    # ["https://ganjoor.net/vahshi/khold-barin/sh", 9, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/vahshi/nazer-manzoor/sh", 31, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/vahshi/farhad-shirin/sh", 44, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/khosro-shirin/sh", 121, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/leyli-majnoon/sh", 46, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/7peykar/sh", 38, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/sharafname/sh", 63, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/kheradname/sh", 50, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/nezami/5ganj/makhzanolasrar/sh", 60, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/razi/saghiname", 1, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/razi/sougandname", 1, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/razi/gouhar-e-eshgh/", 1, "masnavi", False, "مثنوی"],
    # ["https://ganjoor.net/razi/ghazalar/sh", 94, "ghazal", True, "غزل"],
    # ["https://ganjoor.net/razi/ghasidear/sh", 6, "ghaside", True, "قصیده"],
    # ["https://ganjoor.net/razi/robaeear/sh", 100, "robaee", True, "رباعی"],
    # ["https://ganjoor.net/razi/tarjee-band", 1, "tarjee", False, "ترجیع بند"],
    # ["https://ganjoor.net/razi/ghatghaz/sh", 20, "ghazal", True, "غزل و قطعه نا تمام"],
    # ["https://ganjoor.net/razi/mofrar/sh", 9, "mofrad", True, "مفرد"],
    # ["https://ganjoor.net/ebnehesam/ghazalebn/sh", 178, "ghazal", True, "غزل"],
    # ["https://ganjoor.net/ebnehesam/robaeebn/sh", 100, "robaee", True, "غزل"],
    # ["https://ganjoor.net/abusaeed/robaee-aa/sh", 724, "robaee", True, "رباعی"],
    # ["https://ganjoor.net/abusaeed/abyat-aa/sh", 62, "teke", 2, "تکه"],
    # ["https://ganjoor.net/asadi/garshaspname/sh", 144, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/asad/veysoramin/sh", 113, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/azraghi/aghas/sh", 66, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/azraghi/amogh/sh", 9, "ghate", 1, "قطعه"],
    # ["https://ganjoor.net/azraghi/arob/sh", 108, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/iqbal/asrar-khodi/sh", 20, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/romooz-bikhodi/sh", 32, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/payam-mashregh/sh", 300, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/zaboor-ajam/sh", 142, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/javidname/sh", 62, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/pas-che-bayad-kard/sh", 24, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/iqbal/armaghan-hejaz/sh", 393, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/ghazalamkh/sh", 1996, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/khosro/gozide/ghaside-khosro/sh", 6, "ghaside", 0, "قصیده"],
    # ["https://ganjoor.net/khosro/gozide/masnaviatkh/sh", 100, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/matlaolanvar/sh", 14, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/khosro-shirin2/sh", 39, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/majnoon-leyli/sh", 31, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/ayeene-sekandari/sh", 5, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/khosro/gozide/8behesht/sh", 2, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/amir/ghasa/sh", 466, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/amir/taram/sh", 3, "tarkib", 0, "ترکیب"],
    # ["https://ganjoor.net/amir/tarjam/sh", 3, "tarje", 0, "ترجیع"],
    # ["https://ganjoor.net/amir/mosammat", 1, "mosamat", 0, "مسمط"],
    # ["https://ganjoor.net/amir/ghazam/sh", 61, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/amir/ghatam/sh", 34, "ghate", 2, "قطعه"],
    # ["https://ganjoor.net/amir/robam/sh", 174, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/anvari/divan-anvari/ghazala/sh", 321, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/anvari/divan-anvari/ghaside-anvari/sh", 208, "ghaside", 0, "قصیده"],
    # ["https://ganjoor.net/anvari/divan-anvari/ghetea/sh", 491, "ghate", 2, "قطعه"],
    # ["https://ganjoor.net/anvari/divan-anvari/robaeea/sh", 444, "robaee", 1, "قطعه"],
    # ["https://ganjoor.net/ouhadi/divano/ghazalo/sh", 887, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/ouhadi/divano/ghasideo/sh", 42, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/ouhadi/divano/tarjeeato/sh", 2, "tarjee", 0, "ترجیع"],
    # ["https://ganjoor.net/ouhadi/divano/tarkibato/sh", 2, "tarkib", 0, "ترکیب بند"],
    # ["https://ganjoor.net/ouhadi/divano/robaeeo/sh", 184, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/ouhadi/divano/morabba/", 1, "moraba", 0, "مربع"],
    # ["https://ganjoor.net/ouhadi/mantegholoshagh/sh", 77, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/ouhadi/jaamejam/sh", 131, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/babaafzal/robba/sh", 192, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/babaafzal/ghazalba/sh", 7, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/babataher/2beytiha/sh", 366, "2beyti", 1, "دوبیتی"],
    # ["https://ganjoor.net/babataher/ghazal", 1, "ghzal", 0, "غزل"],
    # ["https://ganjoor.net/babataher/ghaside", 1, "ghaside", 0, "قصیده"],
    # ["https://ganjoor.net/bahar/ghasidebk/sh", 276, "ghaside", 3, "قصیده"],
    # ["https://ganjoor.net/bahar/ghazalbk/sh", 101, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/bahar/ghetebk/sh", 191, "ghete", 3, "قطعه"],
    # ["https://ganjoor.net/bahar/masnavibk/sh", 84, "masnavi", 3, "مثنوی"],
    # ["https://ganjoor.net/bahar/mosammatbk/sh", 22, "mosammat", 3, "مسمط"],
    # ["https://ganjoor.net/bahar/tarkibbk/sh", 13, "tarkib", 3, "ترکیب"],
    # ["https://ganjoor.net/bahar/tarjeebk/sh", 9, "tarjee", 3, "ترجیع"],
    # ["https://ganjoor.net/bahar/mostazadbk/sh", 9, "mostazad", 3, "مستزاد"],
    # ["https://ganjoor.net/bahar/4parebk/sh", 6, "4pare", 3, "چهارپاره"],
    # ["https://ganjoor.net/bahar/robaeebk/sh", 71, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/bahar/manzoomebk/ayeene-ebrat/sh", 3, "tarkib", 3, "بخش"],
    # ["https://ganjoor.net/bahar/manzoomebk/karnamez/sh", 88, "masnavi", 3, "بخش"],
    # ["https://ganjoor.net/bahar/manzoomebk/4khatabe/sh", 4, "masnavi", 3, "خطابه"],
    # ["https://ganjoor.net/bahar/manzoomebk/magas/sh", 3, "masnavi", 3, ""],
    # ["https://ganjoor.net/bahar/manzoomebk/madarbk/sh", 8, "masnavi", 3, ""],
    # ["https://ganjoor.net/bahar/manzoomebk/tbad/sh", 10, "tarkib", 3, ""],
    # ["https://ganjoor.net/bahar/manzoomebk/armaghanbk/sh", 118, "masnavi", 3, ""],
    # ["https://ganjoor.net/bahar/mahalibk/sh", 9, "masnavi", 3, ""],
    # ["https://ganjoor.net/bahar/tasnifbk/sh", 18, "tarkib", 3, ""],
    # ["https://ganjoor.net/bidel/ghazalbi/sh", 2827, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/parvin/divanp/ghasidep/sh", 42, "ghaside", 3, "قصیده"],
    # ["https://ganjoor.net/parvin/divanp/mtm/sh", 181, "mix", 3, ""],
    # ["https://ganjoor.net/khaghani/divankh/ghazalkh/sh", 401, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/khaghani/divankh/ghasidekh/sh", 224, "ghaside", 3, ""],
    # ["https://ganjoor.net/khaghani/divankh/robaeekh/sh", 352, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khaghani/divankh/ghetekh/sh", 361, "ghate", 3, "قطعه"],
    # ["https://ganjoor.net/khaghani/divankh/tarjeeatkh/sh", 7, "tarjee", 0, "ترجیع"],
    # ["https://ganjoor.net/khaghani/divankh/tarkibatkh/sh", 9, "tarkib", 0, "ترکیب"],
    # ["https://ganjoor.net/khaghani/divankh/arabikh/sh", 10, "arabi", 0, ""],
    # ["https://ganjoor.net/khajoo/ghazal-khajoo/sh", 932, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/khayyam/robaee/sh", 178, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh1/sh", 15, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh2/sh", 10, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh3/sh", 9, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh4/sh", 22, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh5/sh", 17, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh6/sh", 27, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh7/sh", 7, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/khayyam/tarane/tkh8/sh", 36, "robaee", 1, "رباعی"],

    # ["https://ganjoor.net/hatef/divan-hatef/gar/sh", 29, "mix", 2, ""],
    # ["https://ganjoor.net/roodaki/baghimande/sh", 129, "ghaside", 4, ""],
    # ["https://ganjoor.net/roodaki/robaeer/sh", 38, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/roodaki/masnaviha/kalila-sand/sh", 105, "masnavi", 1, "بخش"],
    # ["https://ganjoor.net/roodaki/masnaviha/motaghareb/sh", 43, "masnavi", 1, "پاره"],
    # ["https://ganjoor.net/roodaki/masnaviha/khafeef/sh", 27, "masnavi", 1, "پاره"],
    # ["https://ganjoor.net/roodaki/masnaviha/hzj/sh", 12, "masnavi", 1, "پاره"],
    # ["https://ganjoor.net/roodaki/masnaviha/digar/sh", 8, "masnavi", 1, "پاره"],
    # ["https://ganjoor.net/roodaki/parakande/sh", 177, "mix", 2, ""],
    # ["https://ganjoor.net/rahi/ghazalha1/sh", 24, "ghazal", 3, "غزل"],
    # ["https://ganjoor.net/rahi/ghazalha2/sh", 24, "ghazal", 3, "غزل"],
    # ["https://ganjoor.net/rahi/ghazalha3/sh", 22, "ghazal", 3, "غزل"],
    # ["https://ganjoor.net/rahi/ghazalha4/sh", 25, "ghazal", 3, "غزل"],
    # ["https://ganjoor.net/rahi/xndghazal/sh", 5, "ghazal", 3, ""],
    # ["https://ganjoor.net/rahi/xndghete/sh", 53, "ghate", 3, "قطعه"],
    # ["https://ganjoor.net/rahi/robaeeha/sh", 19, "robaee", 3, "رباعی"],
    # ["https://ganjoor.net/rahi/manzoomeha/sh", 9, "masnavi", 3, ""],
    # ["https://ganjoor.net/rahi/abyat/sh", 16, "masnavi", 3, ""],
    # ["https://ganjoor.net/helali/ghazalh/sh", 421, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/helali/ghasideh/sh", 4, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/helali/gheteh/sh", 10, "ghate", 2, "قطعه"],
    # ["https://ganjoor.net/helali/robaeeh/sh", 35, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/helali/mkhms", 1, "mokhamas", 0, "مخمس"],
    # ["https://ganjoor.net/helali/shahodarvish/sh", 53, "masnavi", 0, "مثنوی"],
    # ["https://ganjoor.net/hatef/divan-hatef/ghazal-hatef/sh", 90, "ghazal",1, "غزا"],
    # ["https://ganjoor.net/hatef/divan-hatef/tarjeeband", 1, "tarjee", 0, "ترجیع بند"],
    # ["https://ganjoor.net/hatef/divan-hatef/ghaside-hatef/sh", 8, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/hatef/divan-hatef/ghete-hatef/sh", 9, "ghate", 2, "قطعه"],
    # ["https://ganjoor.net/hatef/divan-hatef/motayebat/sh", 2, "motayeb", 2, ""],
    # ["https://ganjoor.net/hatef/divan-hatef/maddetarikh/sh", 45, "masnavi", 2, ""],
    # ["https://ganjoor.net/hatef/divan-hatef/robaee-hatef/sh", 36, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/hatef/divan-hatef/arabih/sh", 3, "arabi", 1, ""],
    # ["https://ganjoor.net/shahriar/torki/sh", 29, "torki", 0, ""],
    # ["https://ganjoor.net/shahriar/heydarbaba2/", 1, "torki", 0, ""],
    # ["https://ganjoor.net/shahriar/heydarbaba/", 1, "torki", 0, ""],
    # ["https://ganjoor.net/shahriar/gozidegh/sh", 160, "ghazal", 1, "غزل"],
    # ["https://ganjoor.net/naserkhosro/divann/ghaside-naser/sh", 281, "ghaside", 1, "قصیده"],
    # ["https://ganjoor.net/naserkhosro/divann/mosammat", 1, "mosamat", 0, "مسمط"],
    # ["https://ganjoor.net/naserkhosro/divann/robaeen/sh", 4, "robaee", 1, "رباعی"],
    # ["https://ganjoor.net/naserkhosro/safarname/sh", 100, "safar", 0, "بخش"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab01/sh", 9, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab02/sh", 5, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab03/sh", 3, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab04/sh", 3, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab05/sh", 3, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab06/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab07/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab08/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab09/sh", 5, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab10/sh", 6, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab11/sh", 4, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab12/sh", 64, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab13/sh", 11, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab14/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab15/sh", 45, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab16/sh", 5, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab17/sh", 8, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab18/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab19/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab20/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab21/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab22/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab23/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab24/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab25/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab26/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab27/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab28/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab29/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab30/sh", 3, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab31/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab32/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab33/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab34/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab35/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab36/sh", 3, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab37/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab38/sh", 2, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab39/sh1", 1, "fasl", 0, "فصل"],
    ["https://ganjoor.net/hojviri/kashfol-mahjoob/kmbab40/sh1", 1, "fasl", 0, "فصل"],
]

classCode = """# -*- coding: utf-8 -*-
import scrapy

class {name}Spider(scrapy.Spider):
    name = "{name}"
    allowed_domains = ["ganjoor.net"]
    if {count} == 1:
        start_urls = ["{url}"]
    else:
        start_urls = ["{url}" + "1"]
    order = 1

    def parse(self, response):
        index = 0
        sh = dict()
        sh["type"] = "{type}"
        sh["text"] = dict()
        for i, poem in enumerate(response.css("div.poem>article>*")):
            if index == 0:
                if {title} == 1:
                    sh["title"] = "{unit}" + " شماره " + str(self.order) + " - " + ''.join(poem.css("div.m1>p::text").extract()).strip()
                elif {title} == 2:
                    sh["title"] = "{unit}" + " شماره " + str(self.order) + " - " + ''.join(poem.css("div.m2>p::text").extract()).strip()
                elif {title} == 3:
                    sh["title"] = "{unit}" + " شماره " + str(self.order) + " - " + ''.join(response.css("div.poem>article>h2>a::text").extract()).strip() + ': ' + ''.join(poem.css("div.m1>p::text").extract()).strip()
                elif {title} == 4:
                    sh["title"] = "{unit}" + " شماره " + str(self.order) + " - " + ''.join(response.css("div.poem>article>h2>a::text").extract()).strip() + ': ' + ''.join(poem.css("div.m2>p::text").extract()).strip()
                else:
                    sh["title"] = ''.join(response.css("div.poem>article>h2>a::text").extract_first()).strip()
            if poem.css("p::text").extract_first() is None or 'rel="bookmark"' in poem.css('*').extract_first() or 'class="spacer"' in poem.css('*').extract_first() or '<div style=' in poem.css('*').extract_first():
                continue
            if len(poem.css("div.m1>p")) == 1:
                if poem.css("div.b"):
                    if '٭٭٭' not in poem.css("div.m1>p::text").extract_first() and ''.join(poem.css("div.m1>p::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("m1", ''.join(poem.css("div.m1>p::text").extract()).strip()),
                            ("m2", ''.join(poem.css("div.m2>p::text").extract()).strip()),
                        ])
                else:
                    if '٭٭٭' not in poem.css("p:first-child::text").extract_first() and ''.join(poem.css("p:first-child::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                            ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                        ])
            else:
                if poem.css("div.b2"):
                    if '٭٭٭' not in poem.css("p:first-child::text").extract_first() and ''.join(poem.css("p:first-child::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                            ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                        ])
                else:
                    if '٭٭٭' not in poem.css('p::text').extract_first() and ''.join(poem.css('p::text').extract()).strip() != '':
                        sh['text'][index] = dict([
                            ('p', ''.join(poem.css('p::text').extract()).strip())
                        ])
            index = index + 1

        sh["order"] = self.order
        self.order = self.order + 1
        yield sh
        # next_page = response.css("div.navigation>div.navleft>a::attr(href)").extract_first()
        if self.order < ({count} + 1):
            next_page = response.urljoin("{url}" + str(self.order))
            yield scrapy.Request(next_page, callback=self.parse)
            """

for url in urls:
    if url[1] == 1:
        name = "scrapy" + (url[0].split("/")[-1]).replace('-', '') + (url[0].split("/")[-2]).replace('-', '')
    else:
        name = "scrapy" + (url[0].split("/")[-2]).replace('-', '')
    book = url[0].split("/")[-3]
    author = url[0].split("/")[-4]
    file = open("ganjoor/spiders/{0}.py".format(name), "w+")
    file.write(classCode.format(name=name, url=url[0], type=url[2], count=url[1], unit=url[4], title=url[3]))
    file.close()
    call(["scrapy", "crawl", "{name}".format(name=name), "-o", "books/{author}/{book}/{name}.json".format(author=author, book=book, name=name)])
    if not os.path.exists("ganjoor/spiders/{author}/{book}/".format(author=author, book=book)):
        os.makedirs("ganjoor/spiders/{author}/{book}/".format(author=author, book=book))
    os.rename("ganjoor/spiders/{name}.py".format(name=name), "ganjoor/spiders/{author}/{book}/{name}.py".format(author=author, book=book, name=name))

/**
 * jQuery TWzipcode plugin
 * https://app.essoduke.org/twzipcode/
 * Copyright 2015 essoduke.org, Licensed MIT.
 *
 * Changelog
 * -------------------------------
 * 加入 placeholder 的支援（by visioncan）
 *
 * @author essoduke.org
 * @version 1.7.5
 * @license MIT License
 */
;(function ($, window, document, undefined) {

    'use strict';

    // Zipcode JSON data
    var data = {
        'Keelung City': {'Charity District': '200', 'Xinyi District': '201', 'Zhongzheng District': '202', 'Zhongshan District': '203', 'Anle District': '204', 'Nuannuan District': '205', 'Qidu District': '206'},
        'Taipei City': {'Zhongzheng District': '100', 'Datong District': '103', 'Zhongshan District': '104', 'Songshan': '105', 'Da\'an District': '106', 'Wanhua District': '108', 'Xinyi District': '110', 'Shilin District': '111', 'Beitou District': '112', 'Neihu District': '114', 'Nangang District': '115', 'Wenshan District': '116'},
        'New Taipei City': {
          'Wanli District': '207', 'Jinshan District': '208', 'Banqiao District': '220', 'Xizhi District': '221', 'Shenkeng District': '222', 'Shiding District': '223',
          'Ruifang District': '224', 'Pingxi District': '226', 'Shuangxi District': '227', 'Gongliao District': '228', 'Xindian District': '231', 'Pinglin District': '232',
          'Wulai District': '233', 'Yonghe District': '234', 'Zhonghe District': '235', 'Tucheng District': '236', 'Sanxia District': '237', 'Shulin District': '238',
          'Yingge District': '239', 'Sanchong District': '241', 'Xinzhuang District': '242', 'Taishan District': '243', 'Linkou District': '244', 'Luzhou District': '247',
          'Wugu District': '248', 'Bali District': '249', 'Tamsui District': '251', 'Sanzhi District': '252', 'Shimen District': '253'
        },
        'Yilan County': {
          'Yilan City': '260', 'Toucheng Township': '261', 'Jiaosi Township': '262', 'Jhuangwei Township': '263', 'Yuanshan Township': '264', 'Luodong Township': '265',
          'Sanshing Township': '266', 'Datong Township': '267', 'Wujie Township': '268', 'Dongshan Township': '269', 'Su\'ao Township': '270', 'Nan\'ao Township': '272',
          'Diaoyutai': '290'
        },
        'Hsinchu City': {'East District': '300', 'North District': '300', 'Xiangshan District': '300'},
        'Hsinchu County': {
          'Zhubei City': '302', 'Hukou Township': '303', 'Xinfeng Township': '304', 'Xinpu Township': '305', 'Guanxi Township': '306', 'Qionglin Township': '307',
          'Baoshan Township': '308', 'Zhudong Township': '310', 'Wufeng Township': '311', 'Hengshan Township': '312', 'Jianshi Township': '313', 'Beipu Township': '314',
          'Omei Township': '315'
        },
        'Taoyuan City': {
          'Zhongli District': '320', 'Pingzhen District': '324', 'Longtan District': '325', 'Yangmei District': '326', 'Xinwu District': '327', 'Guanyin District': '328',
          'Taoyuan District': '330', 'Guishan District': '333', 'Bade District': '334', 'Daxi District': '335', 'Fuxing District': '336', 'Dayuan District': '337',
          'Luzhu District': '338'
        },
        'Miaoli County': {
          'Zhunan Township': '350', 'Toufen City': '351', 'Sanwan Township': '352', 'Nanzhuang Township': '353', 'Shitan Township': '354', 'Houlong Township': '356',
          'Tongxiao Township': '357', 'Yuanli Township': '358', 'Miaoli City': '360', 'Zaociao Township': '361', 'Touwu Township': '362', 'Gongguan Township': '363',
          'Dahu Township': '364', 'Tai\'an Township': '365', 'Tongluo Township': '366', 'Sanyi Township': '367', 'Xihu Township': '368', 'Zhuolan Township': '369'
        },
        'Taichung City': {
          'Central District': '400', 'East District': '401', 'South District': '402', 'West District': '403', 'North District': '404', 'Beitun District': '406', 'Xitun District': '407', 'Nantun District': '408',
          'Taiping District': '411', 'Dali District': '412', 'Wufeng District': '413', 'Wuri District': '414', 'Fengyuan District': '420', 'Houli District': '421',
          'Shigang District': '422', 'Dongshi District': '423', 'Heping District': '424', 'Xinshe District': '426', 'Tanzi District': '427', 'Daya District': '428',
          'Shengang District': '429', 'Dadu District': '432', 'Shalu District': '433', 'Longjing District': '434', 'Wuqi District': '435', 'Qingshui District': '436',
          'Dajia District': '437', 'Waipu District': '438', 'Da-an District': '439'
        },
        'Changhua County': {
          'Changhua City': '500', 'Fenyuan Township': '502', 'Huatan Township': '503', 'Xiushui Township': '504', 'Lukang Township': '505', 'Fuxing Township': '506',
          'Xianxi Township': '507', 'Hemei Township': '508', 'Shengang Township': '509', 'Yuanlin City': '510', 'Shetou Township': '511', 'Yongjing Township': '512',
          'Puxin Township': '513', 'Xihu Township': '514', 'Dacun Township': '515', 'Puyan Township': '516', 'Tianzhong Township': '520', 'Beidou Township': '521',
          'Tianwei Township': '522', 'Pitou Township': '523', 'Xizhou Township': '524', 'Zhutang Township': '525', 'Erlin Township': '526', 'Dacheng Township': '527',
          'Fangyuan Township': '528', 'Ershui Township': '530'
        },
        'Nantou County': {
          'Nantou City': '540', 'Zhongliao Township': '541', 'Caotun Township': '542', 'Guoxing Township': '544', 'Puli Township': '545', 'Ren\'ai Township': '546',
          'Mingjian Township': '551', 'Jiji Township': '552', 'Shueili Township': '553', 'Yuchi Township': '555', 'Sinyi Township': '556', 'Jhushan Township': '557',
          'Lugu Township': '558'
        },
        'Chiayi City': {'East District': '600', 'West District': '600'},
        'Chiayi County': {
          'Fanlu Township': '602', 'Meishan Township': '603', 'Zhuqi Township': '604', 'Alishan Township': '605', 'Zhongpu Township': '606', 'Dapu Township': '607',
          'Shuishang Township': '608', 'Lucao Township': '611', 'Taibao City': '612', 'Puzih City': '613', 'Dongshih Township': '614', 'Lioujiao Township': '615',
          'Xingang Township': '616', 'Minsyong Township': '621', 'Dalin Township': '622', 'Xikou Township': '623', 'Yijhu Township': '624', 'Budai Township': '625'
        },
        'Yunlin County': {
          'Dounan Township': '630', 'Dapi Township': '631', 'Huwei Township': '632', 'Tuku Township': '633', 'Baojhong Township': '634', 'Dongshih Township': '635',
          'Taixi Township': '636', 'Lunbei Township': '637', 'Mailiao Township': '638', 'Douliou City': '640', 'Linnei Township': '643', 'Gukeng Township': '646',
          'Cihtong Township': '647', 'Xiluo Township': '648', 'Erlun Township': '649', 'Beigang Township': '651', 'Shuilin Township': '652', 'Kouhu Township': '653',
          'Sihhu Township': '654', 'Yuanchang Township': '655'
        },
        'Tainan City': {
          'West Central District': '700', 'East District': '701', 'South District': '702', 'North District': '704', 'Anping District': '708', 'Annan District': '709',
          'Yongkang District': '710', 'Gueiren District': '711', 'Xinhua District': '712', 'Zuozhen District': '713', 'Yujing District': '714', 'Nanxi District': '715',
          'Nanhua District': '716', 'Rende District': '717', 'Guanmiao District': '718', 'Longqi District': '719', 'Guantian District': '720', 'Madou District': '721',
          'Jiali District': '722', 'Xigang District': '723', 'Cigu District': '724', 'Jiangjun District': '725', 'Xuejia District': '726', 'Beimen District': '727',
          'Sinying District': '730', 'Houbi District': '731', 'Baihe District': '732', 'Dongshan District': '733', 'Liujia District': '734', 'Xiaying District': '735',
          'Liuying District': '736', 'Yanshui District': '737', 'Shanhua District': '741', 'Danei District': '742', 'Shanshang District': '743', 'Xinshi District': '744',
          'Anding District': '745'
        },
        'Kaohsiung Cit': {
          'Xinxing District': '800', 'Cianjin District': '801', 'Lingya District': '802', 'Yancheng District': '803', 'Gushan District': '804', 'Cijin District': '805',
          'Qianzhen District': '806', 'Sanmin District': '807', 'Nanzih District': '811', 'Xiaogang District': '812', 'Zuoying District': '813',
          'Renwu District': '814', 'Dashe District': '815', 'Dongsha Islands': '817', 'Spratly Islands': '819', 'Gangshan District': '820', 'Luzhu District': '821', 'Alian District': '822', 'Tianliao District': '823',
          'Yanchao District': '824', 'Qiaotou District': '825', 'Tzukuan District': '826', 'Mituo District': '827', 'Yong-an District': '828', 'Hunei District': '829',
          'Fongshan District': '830', 'Daliao District': '831', 'Linyuan District': '832', 'Niaosong District': '833', 'Dashu District': '840', 'Qishan District': '842',
          'Meinong District': '843', 'Liouguei District': '844', 'Neimen District': '845', 'Shanlin District': '846', 'Jiasian District': '847', 'Taoyuan District': '848',
          'Namaxia District': '849', 'Maolin District': '851', 'Qieding District': '852'
        },
        'Pingtung County': {
          'Pingtung City': '900', 'Sandimen Township': '901', 'Wutai Township': '902', 'Majia Township': '903', 'Jiouru Township': '904', 'Ligang Township': '905',
          'Gaoshu Township': '906', 'Yanpu Township': '907', 'Changjhih Township': '908', 'Linluo Township': '909', 'Jhutian Township': '911', 'Neipu Township': '912',
          'Wandan Township': '913', 'Chaozhou Township': '920', 'Taiwu Township': '921', 'Laiyi Township': '922', 'Wanluan Township': '923', 'Kanding Township': '924',
          'Sinpi Township': '925', 'Nanjhou Township': '926', 'Linbian Township': '927', 'Donggang Township': '928', 'Liuqiu Township': '929', 'Jiadong Township': '931',
          'Xinyuan Township': '932', 'Fangliao Township': '940', 'Fangshan Township': '941', 'Chunrih Townsh': '942', 'Shihzih Township': '943', 'Checheng Township': '944',
          'Mudan Township': '945', 'Hengchun Township': '946', 'Manjhou Township': '947'
        },
        'Taitung County': {
          'Taitung City': '950', 'Ludao Township': '951', 'Lanyu Township': '952', 'Yanping Township': '953', 'Beinan Township': '954', 'Luye Township': '955',
          'Guanshan Township': '956', 'Haiduan Township': '957', 'Chihshang Township': '958', 'Donghe Township': '959', 'Chenggong Township': '961', 'Changbin Township': '962',
          'Taimali Township': '963', 'Jinfong Township': '964', 'Dawu Township': '965', 'Daren Township': '966'
        },
        'Hualien County': {
          'Hualien City': '970', 'Xincheng Township': '971', 'Sioulin Township': '972', 'Ji\'an Township': '973', 'Shoufeng Township': '974', 'Fonglin Township': '975',
          'Guangfu Township': '976', 'Fengbin Township': '977', 'Rueisuei Township': '978', 'Wanrong Township': '979', 'Yuli Township': '981', 'Zhuoxi Township': '982',
          'Fuli Township': '983'
        },
        'Kinmen County': {'Jinsha Township': '890', 'Jinhu Township': '891', 'Jinning Township': '892', 'Jincheng Township': '893', 'Lieyu Township': '894', 'Wuqiu Township': '896'},
        'Lienchiang County': {'Nangan Township': '209', 'Beigan Township': '210', 'Juguang Township': '211', 'Dongyin Township': '212'},
        'Penghu County': {'Magong City': '880', 'Xiyu Township': '881', 'Wang\'an Township': '882', 'Qimei Township': '883', 'Baisha Township': '884', 'Huxi Township': '885'}
    };
    /**
     * twzipcode Constructor
     * @param {Object} container HTML element
     * @param {(Object|string)} options User settings
     * @constructor
     */
    function TWzipcode (container, options) {
        /**
         * Default settings
         * @type {Object}
         */
        var defaults = {
            'countyName': 'county',
            'countySel': '',
            'css': [],
            'detect': false,             // v1.6.7
            'districtName': 'district',
            'districtSel': '',
            'onCountySelect': null,      // v1.5
            'onDistrictSelect': null,    // v1.5
            'onZipcodeKeyUp': null,      // v1.5
            'readonly': false,
            'zipcodeName': 'zipcode',
            'zipcodePlaceholder': 'Postal Code',
            'zipcodeSel': '',
            'zipcodeIntoDistrict': false, // v1.6.6
            'googleMapsKey': '' // v1.6.9
        };
        /**
         * DOM of selector
         * @type {Object}
         */
        this.container = $(container);
        /**
         * Merge the options
         * @type {Object}
         */
        this.options = $.extend({}, defaults, options);
        // initialize
        this.init();
    }
    /**
     * TWzipcode prototype
     */
    TWzipcode.prototype = {

        VERSION: '1.7.5',

        /**
         * Method: Get all post data
         * @return {Object}
         */
        data: function () {
            var wrap = this.wrap;
            return 'undefined' !== typeof data[wrap.county.val()] ?
                   data[wrap.county.val()] :
                   data;
        },
        /**
         * Method: Serialize the data
         * @return {string}
         */
        serialize: function () {
            var result = [],
                obj = {},
                ele = {},
                s = {};
            obj = this.container.find('select,input');
            if (obj.length) {
                obj.each(function () {
                    ele = $(this);
                    result.push(ele.attr('name') + '=' + ele.val());
                });
            } else {
                $(this).children().each(function () {
                    s = $(this);
                    result.push(s.attr('name') + '=' + s.val());
                });
            }
            return result.join('&');
        },
        /**
         * Method: Destroy the container.
         * @this {TWzipcode}
         */
        destroy: function () {
            $.data(this.container.get(0), 'twzipcode', null);
            if (this.container.length) {
                return this.container.empty().off('change.twzipcode keyup.twzipcode blur.twzipcode');
            }
        },
        /**
         * Method: Get elements of instance
         * @param {(string|Array)} opts Type name
         * @param {Function} callback Function callback
         */
        get: function (callback) {
            if ('function' === typeof callback) {
                callback.call(this, this.wrap);
            } else {
                return this.wrap;
            }
        },
        /**
         * Method: Set value for elements.
         * @param {(string|number|Object)} opts Input value
         */
        set: function (opts) {

            var self = this,
                def = {
                    'county': '',
                    'district': '',
                    'zipcode': ''
                },
                opt = $.extend({}, def, opts);

            try {
                if ('string' === typeof opts || 'number' === typeof opts) {
                    self.wrap.zipcode.val(opts).trigger('blur.twzipcode');
                } else {
                    if (opt.zipcode) {
                        self.wrap.zipcode.val(opt.zipcode).trigger('blur.twzipcode');
                    }
                    if (opt.county) {
                        self.wrap.county.val(opt.county).trigger('change.twzipcode');
                    }
                    if (opt.district) {
                        self.wrap.district.val(opt.district).trigger('change.twzipcode');
                    }
                }
            } catch (ignore) {
                console.warn(ignore.message);
            } finally {
                return self.container;
            }
        },
        /**
         * Method: Reset the selected items to default.
         * @this {TWzipcode}
         */
        reset: function (container, obj) {
            var self = this,
                wrap = self.wrap,
                county = '',
                list = {
                    'county': '<option value="">Counties</option>',
                    'district': '<option value="">Township Downtown</option>'
                },
                tpl = [];

            switch (obj) {
            case 'district':
                wrap.district.html(list.district);
                break;
            default:
                wrap.county.html(list.county);
                wrap.district.html(list.district);
                for (county in data) {
                    if ('undefined' !== typeof data[county]) {
                        tpl.push('<option value="' + county + '">' + county + '</option>');
                    }
                }
                $(tpl.join('')).appendTo(wrap.county);
                break;
            }
            wrap.zipcode.val('');
        },
        /**
         * Binding the event of the elements
         * @this {TWzipcode}
         */
        bindings: function () {

            var self = this,
                opts = self.options,
                wrap = self.wrap,
                dz   = '',
                dc   = '',
                dd   = '';

            // county
            wrap.county.on('change.twzipcode', function () {
                var val = $(this).val(),
                    district = '',
                    tpl = [];

                wrap.district.empty();

                if (val) {
                    if (true === opts.zipcodeIntoDistrict) {
                        for (district in data[val]) {
                            if ('undefined' !== typeof data[val][district]) {
                                tpl.push('<option value="' + district + '">');
                                tpl.push(data[val][district] + ' ' + district);
                                tpl.push('</option>');
                            }
                        }
                    } else {
                        for (district in data[val]) {
                            if ('undefined' !== typeof data[val][district]) {
                                tpl.push('<option value="' + district + '">');
                                tpl.push(district);
                                tpl.push('</option>');
                            }
                        }
                    }
                    wrap.district.append(tpl.join('')).trigger('change.twzipcode');
                } else {
                    wrap.county.find('option:first').prop('selected', true);
                    self.reset('district');
                }
                // County callback binding
                if ('function' === typeof opts.onCountySelect) {
                    opts.onCountySelect.call(this);
                }
            });
            // District
            wrap.district.on('change.twzipcode', function () {
                var val = $(this).val();
                if (wrap.county.val()) {
                    wrap.zipcode.val(data[wrap.county.val()][val]);
                }
                // District callback binding
                if ('function' === typeof opts.onDistrictSelect) {
                    opts.onDistrictSelect.call(this);
                }
            });
            // Zipcode
            wrap.zipcode.on('keyup.twzipcode blur.twzipcode', function () {
                var obj = $(this),
                    val = '',
                    i   = '',
                    j   = '';
                obj.val(obj.val().replace(/[^0-9]/g, ''));
                val = obj.val().toString();

                if (true !== opts.readonly) {
                    if (3 === val.length) {
                        for (i in data) {
                            if ('undefined' !== typeof data[i]) {
                                for (j in data[i]) {
                                    if ('undefined' !== typeof data[i][j] &&
                                        val === data[i][j]
                                    ) {
                                        wrap.county.val(i).trigger('change.twzipcode');
                                        wrap.district.val(j).trigger('change.twzipcode');
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                // Zipcode callback binding
                if ('function' === typeof opts.onZipcodeKeyUp) {
                    opts.onZipcodeKeyUp.call(this);
                }
            });

            dz = 'undefined' !== typeof opts.zipcodeSel ?
                 opts.zipcodeSel :
                 (
                    'undefined' !== typeof self.role.zipcode.data('value') ?
                    self.role.zipcode.data('value') :
                    opts.zipcodeSel
                 );

            dc = 'undefined' !== typeof opts.countySel ?
                 opts.countySel :
                 (
                    'undefined' !== typeof self.role.county.data('value') ?
                    self.role.county.data('value') :
                    opts.countySel
                 );

            dd = 'undefined' !== typeof opts.districtSel ?
                 opts.districtSel :
                 (
                    'undefined' !== typeof self.role.district.data('value') ?
                    self.role.district.data('value') :
                    opts.districtSel
                 );

            // Default value
            if (dc) {
                self.wrap.county.val(dc).trigger('change.twzipcode');
                if ('undefined' !== typeof data[dc][dd]) {
                    self.wrap.district.val(dd).trigger('change.twzipcode');
                }
            }
            if (dz && 3 === dz.toString().length) {
                self.wrap.zipcode.val(dz).trigger('blur.twzipcode');
            }
        },
        /**
         * Geolocation detect
         * @this {TWzipcode}
         */
        geoLocation: function () {
      var self = this,
                geolocation = navigator.geolocation,
                options = {
                    'maximumAge': 600000,
                    'timeout': 3000,
                    'enableHighAccuracy': false
                },
                opts = self.options;

            if (!geolocation) {
                return;
            }

            geolocation.getCurrentPosition(
                function (loc) {
                    var latlng = {};
                    if (('coords' in loc) &&
                        ('latitude' in loc.coords) &&
                        ('longitude' in loc.coords)
                    ) {
                        latlng = [loc.coords.latitude, loc.coords.longitude];
                        $.getJSON(
                            'https://maps.googleapis.com/maps/api/geocode/json',
                            {
                                'key': opts.googleMapsKey,
                                'sensor': false,
                                'latlng': latlng.join(',')
                            },
                            function (data) {
                                var postal = '';
                                if (data &&
                                    'undefined' !== typeof data.results &&
                                    'undefined' !== typeof data.results[0].address_components &&
                                    'undefined' !== typeof data.results[0].address_components[0]
                                ) {
                                    postal = data.results[0]
                                                 .address_components[data.results[0].address_components.length - 1]
                                                 .long_name;
                                    if (postal) {
                                        self.wrap.zipcode.val(postal.toString()).trigger('blur.twzipcode');
                                    }
                                }
                            });
                    }
                },
                function (error) {
                    console.error(error);
                },
                options
            );
        },
        /**
         * twzipcode Initialize
         * @this {TWzipcode}
         */
        init: function () {

            var self = this,
                container = self.container,
                opts = self.options,
                role = {
                    county: container.find('[data-role=county]:first'),
                    district: container.find('[data-role=district]:first'),
                    zipcode: container.find('[data-role=zipcode]:first')
                },
                countyName = role.county.data('name') || opts.countyName,
                districtName = role.district.data('name') || opts.districtName,
                zipcodeName = role.zipcode.data('name') || opts.zipcodeName,
                zipcodePlaceholder = role.zipcode.data('placeholder') || opts.zipcodePlaceholder,
                readonly = role.zipcode.data('readonly') || opts.readonly;

            // Elements create
            $('<select/>')
                .attr('name', countyName)
                .addClass(role.county.data('style') || ('undefined' !== typeof opts.css[0] ? opts.css[0] : ''))
                .appendTo(role.county.length ? role.county : container);

            $('<select/>')
                .attr('name', districtName)
                .addClass(role.district.data('style') || ('undefined' !== typeof opts.css[1] ? opts.css[1] : ''))
                .appendTo(role.district.length ? role.district : container);

            $('<input/>')
                .attr({'type': 'text', 'name': zipcodeName, 'placeholder': zipcodePlaceholder})
                .prop('readonly', readonly)
                .addClass(role.zipcode.data('style') || ('undefined' !== typeof opts.css[2] ? opts.css[2] : ''))
                .appendTo(role.zipcode.length ? role.zipcode : container);

            self.wrap = {
                'county': container.find('select[name="' + countyName + '"]:first'),
                'district': container.find('select[name="' + districtName + '"]:first'),
                'zipcode': container.find('input[type=text][name="' + zipcodeName + '"]:first')
            };

            if (true === opts.zipcodeIntoDistrict) {
                self.wrap.zipcode.hide();
            }

            self.role = role;
            // Reset the elements
            self.reset();
            // Elements events binding
            self.bindings();
            // Geolocation
            if (true === opts.detect) {
                self.geoLocation();
            }
        }
    };
    /**
     * jQuery twzipcode instance
     * @param {Object} options Plugin settings
     * @public
     */
    $.fn.twzipcode = function (options) {
        var instance = {},
            result = [],
            args = arguments,
            id  = 'twzipcode';
        if ('string' === typeof options) {
            this.each(function () {
                instance = $.data(this, id);
                if (instance instanceof TWzipcode && 'function' === typeof instance[options]) {
                    result = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }
            });
            return 'undefined' !== typeof result ? result : this;
        } else {
            return this.each(function () {
                if (!$.data(this, id)) {
                    $.data(this, id, new TWzipcode(this, options));
                }
            });
        }
    };

})(window.jQuery || {}, window, document);
//#EOF
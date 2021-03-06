PGDMP     &    9            
    x         
   berkatshop    12.3    12.4 %    8           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            9           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            :           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            ;           1262    71651 
   berkatshop    DATABASE     �   CREATE DATABASE berkatshop WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE berkatshop;
                postgres    false            �            1259    71683    failed_jobs    TABLE     �   CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    71681    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    207            <           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    206            �            1259    71654 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    71652    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    203            =           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    202            �            1259    71674    password_resets    TABLE     �   CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 #   DROP TABLE public.password_resets;
       public         heap    postgres    false            �            1259    71693    products    TABLE     �   CREATE TABLE public.products (
    id character varying(50) NOT NULL,
    name character varying(50) NOT NULL,
    price integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.products;
       public         heap    postgres    false            �            1259    71698    sales    TABLE     1  CREATE TABLE public.sales (
    id character varying(50) NOT NULL,
    invoice_number character varying(50) NOT NULL,
    user_id character varying(50) NOT NULL,
    product_id character varying(50) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.sales;
       public         heap    postgres    false            �            1259    71660    users    TABLE       CREATE TABLE public.users (
    id character varying(50) NOT NULL,
    username character varying(50) NOT NULL,
    email character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role character varying(10) NOT NULL,
    level integer NOT NULL,
    status integer NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap    postgres    false            �
           2604    71686    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    206    207    207            �
           2604    71657    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    202    203    203            3          0    71683    failed_jobs 
   TABLE DATA           [   COPY public.failed_jobs (id, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    207   �+       /          0    71654 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    203   �+       1          0    71674    password_resets 
   TABLE DATA           C   COPY public.password_resets (email, token, created_at) FROM stdin;
    public          postgres    false    205   Y,       4          0    71693    products 
   TABLE DATA           K   COPY public.products (id, name, price, created_at, updated_at) FROM stdin;
    public          postgres    false    208   v,       5          0    71698    sales 
   TABLE DATA           `   COPY public.sales (id, invoice_number, user_id, product_id, created_at, updated_at) FROM stdin;
    public          postgres    false    209   u<       0          0    71660    users 
   TABLE DATA           �   COPY public.users (id, username, email, phone, email_verified_at, password, role, level, status, remember_token, created_at, updated_at) FROM stdin;
    public          postgres    false    204   �=       >           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    206            ?           0    0    migrations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.migrations_id_seq', 6, true);
          public          postgres    false    202            �
           2606    71692    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    207            �
           2606    71659    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    203            �
           2606    71697    products products_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.products DROP CONSTRAINT products_pkey;
       public            postgres    false    208            �
           2606    71702    sales sales_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.sales DROP CONSTRAINT sales_pkey;
       public            postgres    false    209            �
           2606    71671    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    204            �
           2606    71673    users users_phone_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phone_unique UNIQUE (phone);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_phone_unique;
       public            postgres    false    204            �
           2606    71667    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    204            �
           2606    71669    users users_username_unique 
   CONSTRAINT     Z   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT users_username_unique;
       public            postgres    false    204            �
           1259    71680    password_resets_email_index    INDEX     X   CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);
 /   DROP INDEX public.password_resets_email_index;
       public            postgres    false    205            �
           1259    71704    sales_product_id_index    INDEX     N   CREATE INDEX sales_product_id_index ON public.sales USING btree (product_id);
 *   DROP INDEX public.sales_product_id_index;
       public            postgres    false    209            �
           1259    71703    sales_user_id_index    INDEX     H   CREATE INDEX sales_user_id_index ON public.sales USING btree (user_id);
 '   DROP INDEX public.sales_user_id_index;
       public            postgres    false    209            �
           2606    71710    sales sales_product_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id) ON UPDATE CASCADE ON DELETE CASCADE;
 H   ALTER TABLE ONLY public.sales DROP CONSTRAINT sales_product_id_foreign;
       public          postgres    false    2729    208    209            �
           2606    71705    sales sales_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;
 E   ALTER TABLE ONLY public.sales DROP CONSTRAINT sales_user_id_foreign;
       public          postgres    false    204    209    2722            3      x������ � �      /   �   x�]��
�0�g�1#���B�M���:���so�ZF`$����e�U%)g7i��������$*�F�=20���KdvK��8Vn�R�L=���r踐�_�S���vd�.H��"X*o����"�kC�q3�|P+Q�      1      x������ � �      4   �  x��ZI�7�>ӿ"os��}�X�KP6��.A2����J!�JF����j�=��d
� ��d1"�-�l'[�e�jh�9����2�Ͷx��Xq{9]�V�0�(��4i��'���?~R�
�7���{i�s2�Z���*�\k&qsi+M���"�,���a�'r��~�C������iwI�V���R�xF�q���&���?>�{z2�������Q��I���ui-t*J��^��;.'��ӛ�G�c�l>Fy�+++�.��Af��]��NQvI����0�]��e>N�^�����䮋ζ�y\�:�t@'tR���h�x��8�[V>�5�^�|a�}r�n>�����_�a����e���t���g�������w�ׂ��~o��F2t�{�TѦn��U�0*3.�l��G~��/��|<M�8+�h����S��2�ؤM�$e����N�YOף^͗�fӧ���"�hvTα
1`z;e %ut_Q������y���L�S�O���sq��u47ߤ� ���*��,�T�C��Ƨ�2=_���ڛ���i�0��Uc��X���()y���A��������~��\g�^-�v�uz��{�?��e�(E&HC:�deʀ��k���[>�ۇ�|'bN�l4m::P"@��_�,�v�T���Βx?�0Yw4q��i�_��	�ϴgܨ�F�l�3�Eƒk,)��4��0������(g���ҋ��5��b+�C��L�=���w�[ ��>{�ϯ�U i|C�H��� О��5�q�
��������@�"�S��ߢ�P� :΃+)��-��ɛ����Ju��P����,�7&���_���j����&�/C���j��%��*Ơ�߁�l���i��ì��
-A�p�?_ �Z���[�y�H`����V��O��_�b~;���e%�0V�mn�t[��w̎�ZJ�]ƀ�X�� �)8�R��	����7q��+����Ӌ�� �f;�)6nI;i- i!�rL��Yyp%�~$~��!/�3�c|�~��ʹB^*?9#3��%��w��J ��f�RPn�cR
h�1��|�V	YIU���F���	���������}����`#l�Q®Yu��4��4ߺ�jeH
Z?A�"$�w��,�K�!3.�b�`Һ�sb������7��3��b�6=:��;��G��e�C��&���Iýզ��-��y} �AĄ�^���4���!%�H���Po�t�Jg\a���&��?��/`|(�Y��"��Ր��"�*�j��ėq�Y�i�T�R[w>1؀{�Y���ߜ�gum�ow��e�;�O�N��#\*�� C���VY���PCu�{ azKP���q�����R
þ��`��_�*Cx�\�|fl%��Y��t7}��k~���'r��< ��֔L�,��A��:4���z���!Fw���r7��,F��ֵb֒r�#�į00�� ���#w;LPdPo��`�p���H�8V�!�և	:6:��Ù��
/�E�~��Ug������`{U���d*f���|Y�����}A�pE��D��	� �����q����s�y�_��'��z^�"o�vBa�L�-�1�^ZͲ�j��1eO��W:�G���|>o�{;�X�G��5X�UF�edTrF��[��?�H�?�|��/���H��FUv1���Ƚ��SzBԮ]���<��/���gx�as�C?�L���J��,�C�,�%�QF�~=A�/��0� �e�?M��.��j��N�l8Io
ꖇy5�1�`���u��=��W>O�1�/��ѱ��Y�j
#�:��@�)�l�%���8��|N��!m��J;o���e��ѥ���Ha�G<?�B�������z��L�%*�������Z6��y*%�GH~�\�e�Jg�#o��l��H:LW��K��1�������˗;:8q��W���U�����o��\�ES��Wy��W��2���ß�C(��~�;J
&1ql�2f������-lw��LG����)�e��k��YPqF��N�{�@�����`#f�Z؊�>�L���Aevs;����0+)BY��Dd���;2e�������|����y��!�I�p{Y�[e(��}�Ŋg�y�<�"yͰ:�=B�*J��'�qD<4��%�t��9�^����'�&�<�q�a$�SݚZ�P�;�9E�X�U8��'
ܲ��O�`͓09e{�jw:�����^f�?���x�(l��Z��Kw���� ����	��1!���E�QjW�
n�]����~���������V�1w'SoxԲDfC��1z-�R�������x`1�j�CkK �ыA���'�E�xA8j��!�c��b�*�=��v-f�Hs��'���5��ٛ��\<[�R��8j�f��َ}����j��a]�Bqax��UWW:I��#(<���x���d�	]��l�T�D!D��u^χAg7��b��K;��U0�(��{38wIH/�H�'6e�v�N�y������ֹ�_M��H�ۻdjƸK�z�i,č�to�?-���9��#��E ����x�c��,;��T�J`�2���_qs��4}88��0Z��OE2	6B:0�j�Zi1H`<"Ks>j5�Y�����g�GБڪd�c'҂,q�
|y⊘�2}���!k���:�$j;6�NL3h����>e->�z��^���R/n~��+�;ܾ����-g̘��+����L���xO�Ā�2��ߤ�	��)�F��d�bu��[N�����,���V̝"3XH��2 \XH���x ��� �K���y�ƫ�1.H�z�<)F�dH-�Rƚ�����c�y���������19	6���P���&��'b���Mq��j!� v��X�32�s"bx�O3�|Y������e�\��k��0�"[ر��:���Т
Pv�Ӡ뜐���i^�T�����+�k�x��`Qmo��-�_)+sxu�w�@8�tw�u��x���>(?|
�!��Z�������l]NWO�il���qݳx�Ҏ�
`�>�~�.[1X�;��zd�Fܬ|@�y�L�跷�W7��TYS�.�wh6v+�Tt����r<-H��vb�|�ၛÄ0S���� .1Z�������ژW������q��os��/�>t�A�t4���<���0�ΰ*�k/D�^<|Hv�l��H�q���	���|~�z��a�����B@��q��
�h+1Vp���yxZFΈ�x�[Mx��=�j��2����Ҵ�u�x.Ɉ�x�������"��v���6�u}�bH¦ �&Wr |m�[z|zgv�wË ��ڄ�4�5�<�a��kf`�'��^�+?�|���S�[��)&�nm �z�"A�h
"Vb2�O�>�=]�ѓoܞ׀)����g���=K_ҷPr|^�rM�B���|�!	ʁP�S0���ui{��L�Jc��,k�V<_�ϱ��{x d�I��ͷ6�A`J�u��0�1�;�`��xyi/b��|�v# &"�#����RAV^����9�L�.�Z� ��8O��� �[�2Y;����t�A�����p0�j�b6쀷�#�0^f�Inbi�:P!:����dw$\��e|�vh3�n�4�5ݾ��7P���?�2w���T�=S)ad��ESE�Q6�3d������g>>Q�A@�ӎ/�T��堾��;.����.������w�R��_�#ͤT��'���;��8��wX��5�����8d;S�*Sp��ID`*�xr�{��>�ϥ]9��n��w|��iK��<��hC5��Um֌,x�f��P��������ݱ�P���B��+Q�TR�PvB�`%nC}s	�ځn�	�u����@W��0%!]�߿��l�6�avw�a�Q9�6 �A�C­���]�5�k]�o	v�:�م�l>����3s      5   B  x���9ND1@�?��F^��PR��Y�<t ��H��y~��0���(A�"jy�8���;##��2�eG��0�$[�h.@'H���5Z�����T��9O
��sƸ�u�؟�_����,��
ú��������J�K�AN4k�P`�*(B��{��G����R��Y>�3h���@c�����\[l�����-*�hͧ���i��'�Gh��I�=��:{�j���l����!��yG��\��WHm���YĢP�J�MQ+�d�Z���d��?�j��Ҡ:/�6��ᣣ;Ŏ� �>���x��n�(��=      0   Z  x���Io�6��ʯ��]�(�p����x�mtCJ��X�cy��e��+�A�B !�x�{�a�b�#"� ���$ 9����)��dg�0+7:(s]l�����uf��n��Pȸ)b��RbX^#t��-U�|������N_���4{��ޢ�a�=���E%�֓��-�����s/o�ux>�^�Wo�Z�h�i>�擽+�\$���Q# ����h&�Ěrby���\����U��Yf7al�mZ�X ����#fDᯈ�j�]��~̚q�n����6���:#��=�g�:��Ꜫ�`�/�u�~�ni��Ml6l��4"��&�1���`UFI��l`�HmdòJ�j�7o�Yz^�0 D��>L����/f���[G�����?�cւ����`�����'}|�:у�%m'���,�ߦ5QY	��^_1�f@B!�(�N�=n�%M���,� �Fǩ��l��D���������b_6u��zݬ_��`��k)��a��q��wɴi����n��V�1>��7�K��h�f�d�_��g{WBHN��@����(��;S�(�E
�2s.��MZm�!���[Z �A�_(W�^3" '�^D|Z���Gh���+�B�i��{��~ߍ���#}o�̮Y�w��.�oŇ��_�E���6�2qa�Pqq���d�8r��l�%�A��*��<��aEe����ů���T����Ym�md���=N�Vu�D��n۞�H�I�_�P�h<���n!^�yM�.a���u�|p�?���ҷ4����l��Y	�U� ���T�	־���k�{�J��r���.��72
��/93uɤ�_��y9¡옇�.��6�l^�j��v��[�y�1lT��KΧ��:��~��G��y��0ܿA�02�٘�`e�Ra��T��*]��g�x���î�@bQ��%_1[�ڷ;/���Yo6_L]c7��l����n��MZ1~c����q0�w���8j��n�Wl�mf���B�8""z�#��I`���O/�FI�R{H�s���+7q���]P�`N��z�}��_�;���Tdr��{=�ry�'���1�K���!c�|u�O��_#ި�V��㷉1�VG>K����� �8�3K�"�r�{����s�����}&o���oHa��B�_��O�M#I]��	L{�x9��������i����]ܹ�~6�u׿�_��	L�Ӥ~��a�s�ÙX3@i�ަT� %!T4б��������+!Lh���_�ߕj�P��.�ᡚ�e�����o�q~<��rV����ی��j�ؠ��=>��tQ T����;��-VW�WWW���     
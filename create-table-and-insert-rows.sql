-- CREATE TABLES
CREATE TABLE order_sale (
    id SERIAL PRIMARY KEY,
    order_date date,
    order_total numeric(10,2),
    order_total_tax numeric(10,2),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone
);

CREATE TABLE type_product (
    id SERIAL PRIMARY KEY,
    description character varying(100),
    tax_percentage numeric(5,2),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone
);

CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    type_product_id integer,
    description character varying(100),
    value numeric(10,2),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
	FOREIGN KEY (type_product_id) REFERENCES type_product (id)
);

CREATE TABLE order_sale_item (
    id SERIAL PRIMARY KEY,
    order_sale_id integer,
	item_number integer,
    product_id integer,
    product_desc character varying(100),
    quantity numeric(10,2),
    price numeric(10,2),
    value_total numeric(10,2),
    value_total_tax numeric(10,2),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
	FOREIGN KEY (order_sale_id) REFERENCES order_sale (id),
	FOREIGN KEY (product_id) REFERENCES product (id)
);

-- INSERT ROWS
INSERT INTO order_sale (order_date, order_total, order_total_tax, created_at) 
values
('2022-05-29', 6000, 1400, now());

INSERT INTO type_product (description, tax_percentage, created_at) 
values
('Tipo de produto1 - 10%', 10, now()),
('Tipo de produto2 - 20%', 20, now()),
('Tipo de produto3 - 20%', 30, now())
;

INSERT INTO product (type_product_id, description, value, created_at) 
values
(1, 'produto1', 100, now()),
(2, 'produto2', 200, now()),
(3, 'produto3', 300, now())
;

INSERT INTO order_sale_item (order_sale_id, product_id, product_desc, quantity, price, value_total, value_total_tax, created_at)
values
(1, 1, 'produto1', 10, 100, 1000, 100, now()),
(1, 2, 'produto2', 10, 200, 2000, 400, now()),
(1, 3, 'produto3', 10, 300, 3000, 900, now());




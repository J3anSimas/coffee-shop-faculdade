CREATE TABLE USERS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    USERNAME VARCHAR(255) NOT NULL,
    PASSWORD VARCHAR(255) NOT NULL,
    EMAIL VARCHAR(255) NOT NULL,
    LVL VARCHAR(1)  NOT NULL,
    CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    UPDATED_AT TIMESTAMP NOT NULL DEFAULT NOW()
);

INSERT INTO USERS (
 USERNAME,
 PASSWORD,
 EMAIL,
 LVL
) VALUES (
	'jeansimas',
    '$2y$10$XDZ7xhdjym3PgWcQztc5POmyhHChzGn24E0O4tv8EBP4pJwVT5HOC', 
    'jean@gmail.com',
    'A'
);

CREATE TABLE COFFEES (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(255) NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    DESCRIPTION VARCHAR(255) NOT NULL,
    CATEGORY VARCHAR(255) NOT NULL,
    IMAGE VARCHAR(255) NOT NULL,
    CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    UPDATED_AT TIMESTAMP NOT NULL DEFAULT NOW()

);

CREATE TABLE CARTS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    USER_ID INTEGER NOT NULL,
    CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    STATUS VARCHAR(1) NOT NULL DEFAULT 'O',
    FOREIGN KEY (USER_ID) REFERENCES USERS(ID)
);
CREATE TABLE CARTS_COFFEES (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    CART_ID INTEGER NOT NULL,
    COFFEE_ID INTEGER NOT NULL,
    QUANTITY INTEGER NOT NULL,
    PRICE DECIMAL(10,2),
    CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    UPDATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    FOREIGN KEY (CART_ID) REFERENCES CARTS(ID),
    FOREIGN KEY (COFFEE_ID) REFERENCES COFFEES(ID)
);
CREATE TABLE ORDERS (
	ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	ZIP_CODE VARCHAR(9),
	STREET VARCHAR(255),
	NUMBER VARCHAR(255),
	COMPLEMENT VARCHAR(255),
	NEIGHBORHOOD VARCHAR(255),
	CITY VARCHAR(255),
	UF VARCHAR(2) NOT NULL,
	PAYMENT_METHOD CHAR(1) NOT NULL,
	CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    UPDATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    CART_ID INTEGER NOT NULL,
    FOREIGN KEY (CART_ID) REFERENCES CARTS(ID)
);

insert into COFFEES (name, price, description, category, image) values ('Expresso Americano', 9.90, 'Expresso diluído, menos intenso que o tradicional', 'TRADICIONAL', 'images/coffees/Americano.png');

insert into COFFEES (name, price, description, category, image) values ('Árabe', 9.90, 'Bebida preparada com grãos de café árabe e especiarias', 'ESPECIAL', 'images/coffees/Arabe.png');

insert into COFFEES (name, price, description, category, image) values ('Café com Leite', 9.90, 'Meio a meio de expresso tradicional com leite vaporizado', 'COM LEITE', 'images/coffees/CafeComLeite.png');

insert into COFFEES (name, price, description, category, image) values ('Expresso Gelado', 9.90, 'Bebida preparada com café expresso e cubos de gelo', 'GELADO', 'images/coffees/CafeGelado.png');

insert into COFFEES (name, price, description, category, image) values ('Capuccino', 9.90, 'Bebida com canela feita de doses iguais de café, leite e espuma', 'COM LEITE', 'images/coffees/Capuccino.png');

insert into COFFEES (name, price, description, category, image) values ('Chocolate Quente', 9.90, 'Bebida feita com chocolate dissolvido no leite quente e café', 'COM LEITE', 'images/coffees/ChocolateQuente.png');

insert into COFFEES (name, price, description, category, image) values ('Cubano', 9.90, 'Drink gelado de café expresso com rum, creme de leite e hortelã', 'ALCOÓLICO', 'images/coffees/Cubano.png');

insert into COFFEES (name, price, description, category, image) values ('Expresso Cremoso', 9.90, 'Café expresso tradicional com espuma cremosa', 'TRADICIONAL', 'images/coffees/ExpressoCremoso.png');

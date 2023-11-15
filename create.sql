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

CREATE TABLE ORDERS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    USER_ID INTEGER NOT NULL,
    FOREIGN KEY (USER_ID) REFERENCES USERS(ID)
);
CREATE TABLE ORDERS_COFFEES (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    ORDER_ID INTEGER NOT NULL,
    COFFEE_ID INTEGER NOT NULL,
    QUANTITY INTEGER NOT NULL,
    CREATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    UPDATED_AT TIMESTAMP NOT NULL DEFAULT NOW(),
    FOREIGN KEY (ORDER_ID) REFERENCES ORDERS(ID),
    FOREIGN KEY (COFFEE_ID) REFERENCES COFFEES(ID)
);

-- $coffees[0] = new coffee("Expresso Americano", "TRADICIONAL", "Expresso diluído, menos intenso que o tradicional", 9.90, "images/coffees/Americano.png");
-- $coffees[1] = new coffee("Árabe", "ESPECIAL", "Bebida preparada com grãos de café árabe e especiarias", 9.90, "images/coffees/Arabe.png");
-- $coffees[2] = new coffee("Café com Leite", "COM LEITE", "Meio a meio de expresso tradicional com leite vaporizado", 9.90, "images/coffees/CafeComLeite.png");
-- $coffees[3] = new coffee("Expresso Gelado", "GELADO", "Bebida preparada com café expresso e cubos de gelo", 9.90, "images/coffees/CafeGelado.png");
-- $coffees[4] = new coffee("Capuccino", "COM LEITE", "Bebida com canela feita de doses iguais de café, leite e espuma", 9.90, "images/coffees/Capuccino.png");
-- $coffees[5] = new coffee("Chocolate Quente", "COM LEITE", "Bebida feita com chocolate dissolvido no leite quente e café", 9.90, "images/coffees/ChocolateQuente.png");
-- $coffees[6] = new coffee("Cubano", "ALCOÓLICO", "Drink gelado de café expresso com rum, creme de leite e hortelã", 9.90, "images/coffees/Cubano.png");
-- $coffees[7] = new coffee("Expresso Cremoso", "TRADICIONAL", "Café expresso tradicional com espuma cremosa", 9.90, "images/coffees/ExpressoCremoso.png");

insert into COFFEES (name, price, description, category, image) values ('Expresso Americano', 9.90, 'Expresso diluído, menos intenso que o tradicional', 'TRADICIONAL', 'images/coffees/Americano.png');

insert into COFFEES (name, price, description, category, image) values ('Árabe', 9.90, 'Bebida preparada com grãos de café árabe e especiarias', 'ESPECIAL', 'images/coffees/Arabe.png');

insert into COFFEES (name, price, description, category, image) values ('Café com Leite', 9.90, 'Meio a meio de expresso tradicional com leite vaporizado', 'COM LEITE', 'images/coffees/CafeComLeite.png');

insert into COFFEES (name, price, description, category, image) values ('Expresso Gelado', 9.90, 'Bebida preparada com café expresso e cubos de gelo', 'GELADO', 'images/coffees/CafeGelado.png');

insert into COFFEES (name, price, description, category, image) values ('Capuccino', 9.90, 'Bebida com canela feita de doses iguais de café, leite e espuma', 'COM LEITE', 'images/coffees/Capuccino.png');

insert into COFFEES (name, price, description, category, image) values ('Chocolate Quente', 9.90, 'Bebida feita com chocolate dissolvido no leite quente e café', 'COM LEITE', 'images/coffees/ChocolateQuente.png');

insert into COFFEES (name, price, description, category, image) values ('Cubano', 9.90, 'Drink gelado de café expresso com rum, creme de leite e hortelã', 'ALCOÓLICO', 'images/coffees/Cubano.png');

insert into COFFEES (name, price, description, category, image) values ('Expresso Cremoso', 9.90, 'Café expresso tradicional com espuma cremosa', 'TRADICIONAL', 'images/coffees/ExpressoCremoso.png');

-- Insertar pizzas
INSERT INTO pizza (id, title, image, price, ok_celiacs) VALUES 
(1, 'Margarita', 'margarita.png', 8.50, true),
(2, 'Cuatro Quesos', 'cuatroquesos.png', 10.00, true),
(3, 'Barbacoa', 'barbacoa.png', 11.50, false);

-- Insertar ingredientes
INSERT INTO ingredient (id, name, id_pizza_id) VALUES
(1, 'Mozzarella', 1),
(2, 'Tomate', 1),
(3, 'Queso Azul', 2),
(4, 'Queso Brie', 2),
(5, 'Carne Barbacoa', 3),
(6, 'Bacon', 3);

-- Insertar pagos de prueba (aunque normalmente se crean con los pedidos)
INSERT INTO payment (id, payment_type, number) VALUES
(1, 'credit_card', '1234567812345678'),
(2, 'bizum', '612345678');

-- Insertar pedidos
INSERT INTO `order` (id, delivery_time, delivery_address, payment_id) VALUES 
(1, '12:30', 'Calle Falsa 123', 1),
(2, '20:00', 'Avenida Siempre Viva 742', 2);

-- Insertar pizzas en pedidos (pizza_order)
INSERT INTO pizza_order (id, id_pizza_id, quantity, id_order_id) VALUES 
(1, 1, 2, 1),
(2, 2, 1, 1),
(3, 3, 1, 2);

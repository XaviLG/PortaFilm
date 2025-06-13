-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2025 a las 13:39:27
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `portafilm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pelicula_id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `user_id`, `pelicula_id`, `texto`, `date`) VALUES
(1, 1, 13, 'Muy buena pelicula!!!!', '2025-06-04'),
(2, 5, 92, 'Muy buenas película. Merecido el Oscar por la interpretación maravillosa de Dicaprio.', '2025-06-12'),
(3, 5, 74, 'Una película que me recuerda mucho a mi infancia. Muy bonita', '2025-06-12'),
(4, 5, 75, 'Que grandiosa película para ver en familia.', '2025-06-12'),
(5, 5, 76, 'Maravillosa película. Todos lloramos viendola', '2025-06-12'),
(6, 5, 26, 'Gran dirección de Nolan. Muy interesante la película', '2025-06-12'),
(7, 5, 98, 'De las mejores películas de animación. Una obra de arte del cine japonés', '2025-06-12'),
(8, 5, 99, 'Muy buena película futurista cyberpunk. Me la vi porque salió la nueva y me alegro de haberlo hecho', '2025-06-12'),
(9, 5, 101, 'Un clásico de Will Smith, muy buena interpretación', '2025-06-12'),
(10, 6, 99, 'Grandiosa película, un poco lenta pero muy buena', '2025-06-12'),
(11, 6, 75, 'Muy entretenida y divertida. Una película maravillosa', '2025-06-12'),
(12, 6, 101, 'Que grandiosa película, no me imagino en un mundo asi', '2025-06-12'),
(13, 6, 74, 'Cuando era niño me daba un poco de miedo, pero ahora me doy cuenta de que es una obra maravillosa', '2025-06-12'),
(14, 6, 76, 'Que grandiosa película, volver a verla de mayor pega mas fuerte. Imposible contener las lagrimas', '2025-06-12'),
(15, 7, 76, 'Que increíble película', '2025-06-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'Acción'),
(4, 'Animación'),
(7, 'Aventura'),
(5, 'Ciencia Ficción'),
(2, 'Comedia'),
(3, 'Drama'),
(8, 'Romance'),
(6, 'Terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mi_lista`
--

CREATE TABLE `mi_lista` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pelicula_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mi_lista`
--

INSERT INTO `mi_lista` (`id`, `user_id`, `pelicula_id`) VALUES
(2, 1, 13),
(3, 3, 13),
(5, 5, 16),
(6, 5, 19),
(9, 5, 20),
(7, 5, 21),
(8, 5, 23),
(15, 5, 24),
(16, 5, 26),
(19, 5, 74),
(18, 5, 75),
(17, 5, 76),
(20, 5, 92),
(10, 5, 98),
(11, 5, 99),
(42, 5, 101),
(24, 6, 26),
(25, 6, 74),
(27, 6, 75),
(21, 6, 76),
(22, 6, 92),
(23, 6, 98),
(28, 6, 99),
(26, 6, 101),
(37, 7, 13),
(38, 7, 14),
(39, 7, 15),
(34, 7, 26),
(29, 7, 74),
(36, 7, 75),
(30, 7, 76),
(40, 7, 80),
(41, 7, 81),
(31, 7, 92),
(32, 7, 98),
(35, 7, 99),
(33, 7, 101);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `portada` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `sipnopsis` longtext NOT NULL,
  `anho` varchar(10) NOT NULL,
  `duracion` varchar(20) NOT NULL,
  `director` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `portada`, `sipnopsis`, `anho`, `duracion`, `director`, `pais`) VALUES
(13, 'Kaiju N8 Tokyo', 'img_68407f9612da0.jpg', 'En un Japón repleto de Kaiju, Kafka Hibino trabaja como limpiador de monstruos. Tras reencontrarse con su amiga de la infancia, Mina Ashiro, una joven promesa de las Fuerzas de Defensa que luchan contra los Kaiju, decide intentar cumplir su antiguo sueño de unirse a las Fuerzas... cuando de repente se transforma en el poderoso Kaiju nº 8. Con la ayuda de un colega más joven, Reno Ichikawa, Kafka oculta su identidad mientras lucha por cumplir el sueño de su vida: aprobar el examen de las Fuerzas de Defensa y así poder estar al lado de Mina. Pero cuando un misterioso Kaiju inteligente ataca una base de las Fuerzas de Defensa, Kafka se enfrenta a una decisión crucial en una situación desesperada... Película recopilatoria que ofrece un resumen repleto de acción de la primera temporada y un nuevo episodio original, \"El día libre de Hoshina\".', '2025', '110 min', 'Shigeyuki Miya, Matsumoto Akanji', 'Japon'),
(14, 'Attack on Titan: The Last Attack', 'img_684a988116deb.jpg', 'Película recopilatoria para cines de los dos últimos episodios especiales de la última temporada de \"Ataque a los Titanes\". La humanidad vivía en paz tras los enormes muros construidos para protegerse de la amenaza de unas criaturas monstruosas llamadas Titanes. Su siglo de paz se vio truncado por un ataque a su ciudad que dejó huérfano de madre a un niño, Eren Yeager, que juró vengarse de los titanes. Años después de unirse a la Tropa de Reconocimiento, Eren se enfrenta a un enemigo mortal y acaba adquiriendo una habilidad especial que revela una nueva verdad sobre el mundo que conoce... Tras aventurarse más allá de los muros y separarse de sus camaradas, Eren, motivado por sus nuevos conocimientos del mundo, planea el \"Retumbar\", un terrorífico plan para erradicar a todo ser vivo del mundo. Con el destino del mundo pendiendo de un hilo, un variopinto grupo de antiguos camaradas y enemigos de Eren lucha por detener su letal misión. La única pregunta es: ¿lo conseguirán?', '2024', '145 min', 'Yuichiro Hayashi', 'Japón'),
(15, 'Dune: Parte Dos', 'img_684a98ce8a17b.jpg', 'Tras los sucesos de la primera parte acontecidos en el planeta Arrakis, el joven Paul Atreides se une a la tribu de los Fremen y comienza un viaje espiritual y marcial para convertirse en mesías, mientras intenta evitar el horrible pero inevitable futuro que ha presenciado: una Guerra Santa en su nombre, que se extiende por todo el universo conocido... Secuela de \'Dune\' (2021).', '2024', '166 min', 'Denis Villeneuve', 'Estados Unidos'),
(16, 'Memorias de un caracol', 'img_684a9910b0d1a.jpg', 'Australia, años 70. Grace Pudel es una niña solitaria e inadaptada, aficionada a coleccionar figuras decorativas de caracoles y con una devoción profunda por las novelas románticas. La muerte de su padre cuando tan solo es una niña, la lleva a tener que separarse de su hermano mellizo, Gilbert, lo que la aboca a una espiral de ansiedad y angustia. Sin embargo, la esperanza vuelve a su vida cuando conoce a una excéntrica anciana llena de determinación y amor por la vida llamada Pinky, con la que entablará una larga amistad que le cambiará la vida para siempre.', '2024', '94 min', 'Adam Elliot', 'Australia'),
(17, 'Robot salvaje', 'img_684a996696d88.jpg', 'El épico viaje de un robot -la unidad 7134 de Roz,\'Roz\' para abreviar- que naufraga en una isla deshabitada y debe aprender a adaptarse al duro entorno, entablando gradualmente relaciones con los animales de la isla y convirtiéndose en madre adoptiva de un pequeño ganso huérfano.', '2024', '98 min', 'Chris Sanders', 'Estados Unidos'),
(18, 'Aún estoy aquí', 'img_684a99aedda56.jpg', 'Basada en las memorias de Marcelo Rubens Paiva, en las que narra\r\ncómo su madre se vio obligada al activismo político cuando su marido, el diputado izquierdista Rubens Paiva, fue capturado por el gobierno durante la dictadura militar de Brasil, en 1971.', '2024', '137 min', 'Walter Salles', 'Brasil'),
(19, 'La historia de Souleymane', 'img_684a99e5a9f50.jpg', 'Mientras pedalea por las calles de París para repartir comidas, Souleymane repite su historia. En dos días tiene que pasar la entrevista de solicitud de asilo, la clave para obtener papeles. Pero Souleymane no está preparado.', '2024', '92 min', 'Boris Lojkine', 'Francia'),
(20, 'Flow, un mundo que salvar', 'img_684a9a196dd50.jpg', 'Un gato se despierta en un mundo cubierto de agua, donde la raza humana parece haber desaparecido. Busca refugio en un barco con un grupo de otros animales. Pero llevarse bien con ellos resulta ser un reto aún mayor que superar su miedo al agua. Todos tendrán que aprender a superar sus diferencias y adaptarse a este nuevo mundo en el que se encuentran.', '2024', '83 min', 'Gints Zilbalodis', 'Letonia'),
(21, 'El conde de Montecristo', 'img_684a9a56b09b8.jpg', 'Todos los sueños del joven Edmundo Dantès están a punto de hacerse realidad, y por fin podrá casarse con el amor de su vida, Mercedes. Pero su éxito inspira la envidia desde varios frentes. Traicionado por sus rivales y denunciado como miembro de una conspiración pro-Bonaparte, es encarcelado sin juicio en el Château d\'If. Su compañero de prisión, Abbé Faria, le habla del legendario tesoro escondido en la isla de Montecristo, y Dantés sueña con escapar y urdir un plan extraordinario para vengarse de sus poderosos enemigos.', '2024', '178 min', 'Matthieu Delaporte, Alexandre de La Patellière', 'Francia'),
(22, 'Cómo hacerse millonario antes de que muera la abuela', 'img_684a9a8bb3fb1.jpg', 'Cuando \'M\', un joven holgazán y quejica, descubre que su abuela sufre una enfermedad terminal, decide dejar a un lado su precaria carrera como streamer para cuidar de ella. Eso sí, con la mirada puesta en su patrimonio multimillonario... Pero ganarse a la abuela no es fácil. Resulta ser una mujer de armas tomar, exigente, rigurosa y muy difícil de complacer. Y, por si fuera poco, \'M\' no parece ser el descendiente interesado.', '2024', '126 min', 'Pat Boonnitipat', 'Tailandia'),
(23, 'El 47', 'img_684a9ab6dce20.jpg', '\"El 47\" cuenta la historia de un acto de disidencia pacífica y el movimiento vecinal de base que en 1978 transformó Barcelona y cambió la imagen de sus suburbios para siempre. Manolo Vital era un conductor de autobús que se adueñó del bus de la línea 47 para desmontar una mentira que el Ayuntamiento se empeñaba en repetir: los autobuses no podían subir las cuestas del distrito de Torre Baró. Un acto de rebeldía que demostró ser un catalizador para el cambio, de que las personas se enorgullecen de sus raíces, de una lucha del vecindario, de la clase trabajadora que ayudó a crear la Barcelona moderna de los años 70.', '2024', '110 min', 'Marcel Barrena', 'España'),
(24, 'Spider-Man: Cruzando el Multiverso', 'img_684a9b0107c84.jpg', 'Tras reencontrarse con Gwen Stacy, el amigable vecindario de Spider-Man de Brooklyn al completo es catapultado a través del Multiverso, donde se encuentra con un equipo de Spidermans encargados de proteger su propia existencia. Pero cuando los héroes se enfrentan sobre cómo manejar una nueva amenaza, Miles se encuentra enfrentado a las otras Arañas y debe redefinir lo que significa ser un héroe para poder salvar a la gente que más quiere.', '2023', '140 min', 'Joaquim Dos Santos, Kemp Powers, Justin K. Thompson', 'Estados Unidos'),
(25, 'La sociedad de la nieve', 'img_684a9b2cd4fad.jpg', 'En 1972, el vuelo 571 de la Fuerza Aérea Uruguaya, fletado para llevar a un equipo de rugby a Chile, se estrella en un glaciar en el corazón de los Andes. Solo 29 de sus 45 pasajeros sobreviven al accidente. Atrapados en uno de los entornos más inaccesibles y hostiles del planeta, se ven obligados a recurrir a medidas extremas para mantenerse con vida.', '2023', '144 min', 'J.A. Bayona', 'España'),
(26, 'Oppenheimer', 'img_684a9b69d7298.jpg', 'En tiempos de guerra, el brillante físico estadounidense Julius Robert Oppenheimer, al frente del \'Proyecto Manhattan\', lidera los ensayos nucleares para construir la bomba atómica para su país. Impactado por su poder destructivo, Oppenheimer se cuestiona las consecuencias morales de su creación. Desde entonces y el resto de su vida, se opondría firmemente al uso de armas nucleares.', '2023', '180 min', 'Christopher Nolan', 'Estados Unidos'),
(27, 'Monstruo', 'img_684a9baad13c9.jpg', 'Cuando su joven hijo Minato empieza a comportarse de forma extraña, su madre siente que algo va mal. Al descubrir que el responsable de todo ello es un profesor, irrumpe en la escuela exigiendo saber qué está pasando. Pero a medida que la historia se desarrolla a través de los ojos de la madre, el profesor y el niño, la verdad va saliendo a la luz, poco a poco...', '2023', '126 min', 'Hirokazu Koreeda', 'Japón'),
(28, 'Psicosis', 'img_684a9c6f8fe11.jpg', 'Marion Crane, una joven secretaria, tras cometer el robo de un dinero en su empresa, huye de la ciudad y, después de conducir durante horas, decide descansar en un pequeño y apartado motel de carretera regentado por un tímido joven, Norman Bates, que vive en la casa de al lado con su madre.', '1960', '109 min', 'Alfred Hitchcock', 'Estados Unidos'),
(29, 'La matanza de Texas', 'img_684a9c9c81387.jpg', 'Cinco adolescentes visitan la tumba, supuestamente profanada, del abuelo de uno de ellos. Cuando llegan al lugar, donde hay un siniestro matadero, toman una deliciosa carne en una gasolinera. A partir de ese momento, los jóvenes vivirán la peor pesadilla de toda su vida.', '1974', '83 min', 'Tobe Hooper', 'Estados Unidos'),
(30, 'El exorcista', 'img_684a9cc294638.jpg', 'Regan, una niña de doce años, sufre fenómenos paranormales como la levitación o la manifestación de una fuerza sobrehumana. Su madre, aterrorizada, tras someter a su hija a múltiples análisis médicos que no ofrecen ningún resultado, acude a un sacerdote con estudios de psiquiatría. Éste, convencido de que el mal no es físico sino espiritual, cree que se trata de una posesión diabólica, y decide practicar un exorcismo... Adaptación de la novela de William Peter Blatty que se inspiró en un exorcismo real ocurrido en Washington en 1949.', '1973', '121 min', 'William Friedkin', 'Estados Unidos'),
(31, 'Alien, el octavo pasajero', 'img_684a9dc23c1c7.jpg', 'De regreso a la Tierra, la nave de carga Nostromo interrumpe su viaje y despierta a sus siete tripulantes. El ordenador central, MADRE, ha detectado la misteriosa transmisión de una forma de vida desconocida, procedente de un planeta cercano aparentemente deshabitado. La nave se dirige entonces al extraño planeta para investigar el origen de la comunicación.', '1979', '116 min', 'Ridley Scott', 'Reino Unido'),
(32, 'El proyecto de la bruja de Blair', 'img_684a9e080c10b.jpg', 'El 21 de octubre de 1994, Heather Donahue, Joshua Leonard y Michael Williams entraron en un bosque de Maryland para rodar un documental sobre una leyenda local, \"La bruja de Blair\". No se volvió a saber de ellos. Un año después, fue encontrada la cámara con la que rodaron: mostraba los terroríficos hechos que dieron lugar a su desaparición.', '1999', '81 min', 'Daniel Myrick, Eduardo Sánchez', 'Estados Unidos'),
(33, 'El resplandor', 'img_684a9e392831d.jpg', 'Jack Torrance se traslada con su mujer y su hijo de siete años al impresionante hotel Overlook, en Colorado, para encargarse del mantenimiento de las instalaciones durante la temporada invernal, época en la que permanece cerrado y aislado por la nieve. Su objetivo es encontrar paz y sosiego para escribir una novela. Sin embargo, poco después de su llegada al hotel, al mismo tiempo que Jack empieza a padecer inquietantes trastornos de personalidad, se suceden extraños y espeluznantes fenómenos paranormales.', '1980', '146 min', 'Stanley Kubrick', 'Reino Unido'),
(34, 'La noche de Halloween', 'img_684aa1215664d.jpg', 'Durante la noche de Halloween, Michael, un niño de seis años, asesina a su familia con un cuchillo de cocina. Es internado en un psiquiátrico del que huye quince años más tarde, precisamente la víspera de Halloween. El psicópata vuelve a su pueblo y comete una serie de asesinatos. Mientras, uno de los médicos del psiquiátrico le sigue la pista.', '1978', '93 min', 'John Carpenter', 'Estados Unidos'),
(35, 'Scream. Vigila quién llama', 'img_684aa14f4cee1.jpg', 'Un año después del asesinato de su madre, Sidney (Neve Campbell) vuelve a vivir una situación angustiosa: mientras un terrible psicópata tiene aterrorizado al barrio, su padre está siempre ausente y su novio está a punto de romper con ella.', '1996', '111 min', 'Wes Craven', 'Estados Unidos'),
(36, 'Muñeco diabólico', 'img_684aa1829917c.jpg', 'El vudú y el terror se apoderan de un muñeco de aspecto inocente habitado por el alma de un asesino en serie. Cuando Andy Barclay, un niño de seis años de edad, asegura que “Chucky”, su nuevo muñeco, ha arrojado violentamente por la ventana a su niñera, nadie le cree. Pero una larga serie de horribles asesinatos conduce al detective que se ocupa del caso hasta el muñeco y, entonces, descubre que el auténtico terror no ha hecho más que empezar. El malvado muñeco pretende transferir su diabólico espíritu a un ser humano, y el pequeño Andy parece ser el candidato perfecto.', '1988', '87 min', 'Tom Holland', 'Estados Unidos'),
(37, 'Saw', 'img_684aa1ae6a36a.jpg', 'Adam se despierta encadenado dentro de una decrépita cámara subterránea. A su lado, hay otra persona encadenada, el Dr. Lawrence Gordon. Entre ellos hay un hombre muerto. Ninguno de los dos sabe por qué está allí, pero tienen un casette con instrucciones para que el Dr. Gordon mate a Adam en un plazo de ocho horas. Recordando una investigación de asesinato llevada a cabo por un detective llamado Tapp, Gordon descubre que él y Adam son victimas de un psicópata conocido como Jigsaw. Sólo disponen de unas horas para desenredar el complicado rompecabezas en el que están inmersos.', '2004', '100 min', 'James Wan', 'Estados Unidos'),
(38, 'La noche de los muertos vivientes', 'img_684aa1e3cef23.jpg', 'Las radiaciones procedentes de un satélite provocan un fenómeno terrorífico: los muertos salen de sus tumbas y atacan a los hombres para alimentarse. La acción comienza en un cementerio de Pennsylvania, donde Barbara, después de ser atacada por un muerto viviente, huye hacia una granja. Allí también se ha refugiado Ben. Ambos construirán barricadas para defenderse de una multitud de despiadados zombies que sólo pueden ser vencidos con un golpe en la cabeza.', '1968', '96 min', 'George A. Romero', 'Estados Unidos'),
(39, 'Expediente Warren: The Conjuring', 'img_684aa211733a3.jpg', 'Basada en una historia real documentada por los reputados demonólogos Ed y Lorraine Warren. Narra los encuentros sobrenaturales que vivió la familia Perron en su casa de Rhode Island a principios de los 70. El matrimonio Warren, investigadores de renombre en el mundo de los fenómenos paranormales, acudieron a la llamada de esta familia aterrorizada por la presencia en su granja de un ser maligno.', '2013', '112 min', 'James Wan', 'Estados Unidos'),
(40, '[•REC]', 'img_684aa2403146a.jpg', 'Cada noche, Ángela (Manuela Velasco), una joven reportera de una televisión local, sigue con su cámara a un grupo profesional distinto. Esta noche le toca entrevistar a los bomberos y tiene la secreta esperanza de poder asistir en directo a un impactante incendio. Pero la noche transcurre tranquilamente. Y cuando, por fin, reciben la llamada de una anciana que se ha quedado encerrada en su casa, no le queda otro remedio que seguirlos durante la misión de rescate. En el edificio donde vive la anciana, los vecinos están muy asustados. La mujer, encerrada en su piso, lanza unos gritos desgarradores... Es sólo el comienzo de una larga pesadilla y de un dramático reportaje único en el mundo.', '2007', '76 min', 'Jaume Balagueró, Paco Plaza', 'España'),
(41, 'El sexto sentido', 'img_684aa2742637c.jpg', 'El doctor Malcom Crowe es un conocido psicólogo infantil de Philadelphia que vive obsesionado por el doloroso recuerdo de un joven paciente desequilibrado al que fue incapaz de ayudar. Cuando conoce a Cole Sear, un aterrorizado y confuso niño de ocho años que necesita tratamiento, ve que se le presenta la oportunidad de redimirse haciendo todo lo posible por ayudarlo. Sin embargo, el doctor Crowe no está preparado para conocer la terrible verdad acerca del don sobrenatural de su paciente: recibe visitas no deseadas de espíritus atormentados.', '1999', '107 min', 'Estados Unidos', 'M. Night Shyamalan'),
(42, 'Sé lo que hicisteis el último verano', 'img_684aa29bda4e4.jpg', 'Una noche de verano, cuando volvían de una fiesta, dos jóvenes parejas en estado de embriaguez atropellan a un hombre en una carretera desierta. Confundidos y asustados, deciden tirar el cadáver al mar. Un año después, una de las chicas, Julie, recibe un mensaje en el que alguien dice saber qué pasó el verano anterior. A partir de ese momento, un hombre con gabán de marino y un garfio se dedica a matar a los adolescentes.', '1997', '101 min', 'Jim Gillespie', 'Estados Unidos'),
(43, 'La semilla del diablo', 'img_684aa2ceea42d.jpg', 'Los Woodhouse, un matrimonio neoyorquino, se mudan a un edificio situado frente a Central Park, sobre el cual, según un amigo, pesa una maldición. Una vez instalados, se hacen amigos de Minnie y Roman Castevet, unos vecinos que los colman de atenciones. Ante la perspectiva de un buen futuro, los Woodhouse deciden tener un hijo; pero, cuando Rosemary se queda embarazada, lo único que recuerda es haber hecho el amor con una extraña criatura que le ha dejado el cuerpo lleno de marcas. Con el paso del tiempo, Rosemary empieza a sospechar que su embarazo no es normal.', '1968', '136 min', 'Roman Polanski', 'Estados Unidos'),
(44, 'La parada de los monstruos', 'img_684aa2f3e8929.jpg', 'En un circo lleno de seres deformes, tullidos y personas con diversas amputaciones, Hans, uno de los enanos, hereda una fortuna. A partir de ese momento, Cleopatra, una bella trapecista, intentará seducirlo para hacerse con su dinero. Para lograr su objetivo, traza un plan contando con la complicidad de Hércules, el forzudo del circo.', '1932', '64 min', 'Tod Browning', 'Estados Unidos'),
(45, 'Amanecer de los muertos', 'img_684aa327539ce.jpg', 'Remake del filme de terror de George A. Romero. Una inexplicable plaga ha diezmado la población del planeta, convirtiendo a los muertos en horribles zombies que continuamente buscan carne y sangre humana para sobrevivir. En Wisconsin, un variopinto grupo de personas que han escapado a la plaga, tratan de salvar la vida refugiándose en un centro comercial, donde deben aprender no sólo a protegerse de las hordas de zombies, sino también a convivir.', '2004', '100 min', 'Zack Snyder', 'Estados Unidos'),
(46, 'Guardianes de la noche', 'img_684aa358cca4c.jpg', 'Al caer la noche, las fuerzas de la oscuridad combaten contra los “Otros”, sobrehumanos, Guardianes de la Noche, cuya misión es patrullar y proteger a la humanidad, manteniendo la calma. Pero existe un temor constante de que una antigua profecía se convierta en realidad: que un poderoso “Otro” aparecerá, será tentado por uno de los lados e inclinará la balanza, haciendo que se desate una guerra entre la luz y la oscuridad, cuyos resultados pueden ser catastróficos.', '2004', '114 min', 'Timur Bekmambetov', 'Rusia'),
(47, 'Paranormal Activity', 'img_684aa380cc256.jpg', 'Una pareja feliz, joven y de clase media ve su vida atormentada por un espíritu demoníaco. Ella es una estudiante que está punto de graduarse como profesora, y él, un corredor de bolsa que trabaja desde su casa. Viven desde hace tres años en una casa que hasta el momento les parecía completamente normal; pero, inesperadamente, extraños fenómenos paranormales empiezan a perturbar su vida.', '2007', '99 min', 'Oren Peli', 'Estados Unidos'),
(48, 'Pretty Woman', 'img_684aa3f32fdf1.jpg', 'Edward Lewis (Richard Gere), un apuesto y rico hombre de negocios, contrata a una prostituta, Vivian Ward (Julia Roberts), durante un viaje a Los Angeles. Tras pasar con ella la primera noche, Edward le ofrece dinero a Vivian para que pase con él toda la semana y le acompañe a diversos actos sociales.', '1990', '119 min', 'Garry Marshall', 'Estados Unidos'),
(49, '(500) días juntos', 'img_684aa41db6968.jpg', 'Tom aún sigue creyendo, incluso en este cínico mundo moderno, en la noción de un amor transformador, predestinado por el cosmos y que golpea como un rayo sólo una vez. Summer no cree lo mismo, para nada. La mecha se enciende desde el primer día, cuando Tom, un arquitecto en ciernes convertido en un sensiblero escritor de tarjetas de felicitación, se encuentra con Summer, la bella y fresca nueva secretaria de su jefe. Aunque aparentemente está fuera de su alcance, Tom pronto descubre que tienen un montón de cosas en común. La historia de Tom y Summer cubre desde el enamoramiento, las citas y el sexo hasta la separación, las recriminaciones y la redención, todo lo cual se suma al caleidoscópico retrato del porqué y el cómo seguimos esforzándonos de modo tan risible y rastrero para encontrar sentido al amor… y esperar convertirlo en realidad.', '2009', '96 min', 'Marc Webb', 'Estados Unidos'),
(50, 'Notting Hill', 'img_684aa44a16ba2.jpg', 'William (Hugh Grant), tranquilo propietario de una pequeña librería de viajes en el popular barrio londinense de Notting Hill, conoce un día por casualidad a la famosa Anna Scott (Julia Roberts), la estrella más rutilante del firmamento cinematográfico actual. Desde el momento en que la actriz entra en su tienda, la vida de William empezará a cambiar.', '1999', '124 min', 'Roger Michell', 'Reino Unido'),
(51, 'Algo para recordar', 'img_684aa478bf274.jpg', 'Tras la muerte de su esposa, el arquitecto Sam Baldwin (Tom Hanks) se encuentra muy abatido. Su hijo Jonah, convencido de que su padre necesita una mujer que le devuelva la alegría de vivir, el día de Navidad llama a un programa de radio para contar su historia. Miles de mujeres lo escuchan: una de ellas, Annie Reed (Meg Ryan), que está a punto de contraer matrimonio empieza a obsesionarse con la idea de conocer a Sam antes de casarse con su novio.', '1993', '101 min', 'Nora Ephron', 'Estados Unidos'),
(52, 'Un día inolvidable', 'img_684aa5eabb852.jpg', 'Melanie Parker (Michelle Pfeiffer) trabaja como arquitecta en Nueva York mientras cría a su único hijo. Es una mujer dedicada íntegramente a su trabajo que vive alejada de los hombres, de los que no quiere saber nada. Por su parte Jack Taylor (George Clooney) es un periodista divorciado que también tiene que hacerse cargo de su hija. Al igual que Melanie, carece de vida sentimental. Sin embargo, el destino hará que ambos se encuentren.', '1996', '109 min', 'Michael Hoffman', 'Estados Unidos'),
(53, 'La boda de mi mejor amigo', 'img_684aa6184126d.jpg', 'Julianne Potter, una crítica gastronómica, se da cuenta de que está enamorada de su mejor amigo justo el día que él la llama para anunciarle que se va a casar con una chica de la alta sociedad. Sólo dispone de tres días para urdir un plan que le permita impedir la boda.', '1997', '105 min', 'P.J. Hogan', 'Estados Unidos'),
(54, 'Tú y yo', 'img_684aa647ba4a4.jpg', 'Un elegante playboy y una bella cantante de un club nocturno se conocen a bordo de un lujoso transatlántico y surge entre ellos un apasionado romance. Aunque ambos están comprometidos (ella es la amante de un magnate y él se va a casar con una rica heredera), establecen un pacto antes de abandonar el barco: encontrarse en el Empire State Building en un plazo de seis meses si siguen sintiendo lo mismo el uno por el otro.', '1957', '119 min', 'Leo McCarey', 'Estados Unidos'),
(55, 'El diario de Bridget Jones', 'img_684aa66f05ed6.jpg', 'Bridget Jones es una treintañera soltera y llena de complejos, cuya vida sentimental es un desastre. Tiene sólo dos ambiciones: adelgazar y encontrar el amor verdadero. El día de Año Nuevo toma dos decisiones: perder peso y escribir un diario. Pero muy pronto su vida amorosa se vuelve a complicar, pues se encuentra dividida entre dos hombres. Por un lado, Daniel Cleaver, su jefe, un tipo encantador y sexy, pero peligroso; por otro, Mark Darcy, un viejo amigo de la familia, que al principio le parece demasiado reservado y aburrido.', '2001', '100 min', 'Sharon Maguire', 'Reino Unido'),
(56, 'Shakespeare enamorado', 'img_684aa6bc17ba9.jpg', 'Londres, 1593, reinado de Isabel I Tudor. William Shakespeare, joven dramaturgo de gran talento, necesita urgentemente poner fin a la mala racha por la que está pasando su carrera. Por mas que lo intenta y, a pesar de la presión de los productores y de los dueños de salas de teatro, no consigue concentrarse en su nueva obra: \"Romeo y Ethel, la hija del pirata\". Lo que Will necesita es una musa y la encontrará en la bella Lady Viola, con la que mantiene un romance secreto. Ahora bien, ella guarda dos secretos que él debe descubrir.', '1998', '123 min', 'John Madden', 'Estados Unidos'),
(57, 'Cuando Harry encontró a Sally', 'img_684aa6e5ed85e.jpg', 'Harry Burns (Billy Cristal) y Sally Albright (Meg Ryan) son dos estudiantes universitarios que se conocen por casualidad, cuando ella se ofrece a llevar Harry en su coche. Durante el viaje hablan sobre la amistad entre personas de diferente sexo y sus opiniones son absolutamente divergentes: mientras que Harry está convencido de que la amistad entre un hombre y una mujer es imposible, Sally cree lo contrario. A pesar de ello, pasan los años y su relación continúa.', '1989', '96 min', 'Rob Reiner', 'Estados Unidos'),
(58, 'Tienes un e-mail', 'img_684aa7115efc0.jpg', 'Kathleen Kelly, la propietaria de una pequeña librería de cuentos infantiles, ve peligrar su negocio cuando una cadena de grandes librerías abre un local al lado de su tienda. Cuando conoce a Joe Fox, el hijo del dueño de la cadena, sentirá inmediatamente por él una gran antipatía. Lo que ambos ignoran es que mantienen una relación por correo electrónico.', '1998', '119 min', 'Nora Ephron', 'Estados Unidos'),
(59, 'Novia a la fuga', 'img_684aa739ef3e9.jpg', 'Ike Graham (Richard Gere), redactor de un periódico de Nueva York, se entera del caso de Maggie (Julia Roberts), una joven que vive en una zona rural del estado de Maryland que tiene el curioso hábito de huir del altar justo antes de contraer matrimonio. Intrigado, Ike escribe una columna sobre el caso de la joven, sin prever el enfado de Maggie y la cadena de enredos que acabará desatando.', '1999', '118 min', 'Garry Marshall', 'Estados Unidos'),
(61, 'Dos en la carretera', 'img_684aa765d0868.jpg', 'Un viaje de Londres a la Riviera francesa hará que Joanna y su marido Mark revivan los románticos comienzos de su relación, los primeros años de su matrimonio y sus respectivas infidelidades. Con el paso del tiempo los dos han cambiado, por lo que tendrán que enfrentarse a un dilema: separarse o aceptarse mutuamente tal como son.', '1967', '111 min', 'Stanley Donen', 'Reino Unido'),
(62, 'Planes de boda', 'img_684aa7b57c22e.jpg', 'Mary Fiore (Jennifer López) es la más prestigiosa organizadora de bodas de San Francisco. Está tan ocupada en hacer realidad los sueños de los demás, que no tiene tiempo para ocuparse de su propia vida. Un día, por casualidad, conoce a un apuesto médico que le salva la vida y del que se queda prendada. Lo malo es que resulta ser su próximo cliente.', '2001', '100 min', 'Adam Shankman', 'Estados Unidos'),
(63, 'Una cuestión de tiempo', 'img_684aa7d8a5fad.jpg', 'Tim Lake (Domhnall Gleeson) es un joven de 21 años que descubre que puede viajar en el tiempo. Su padre (Bill Nighy) le cuenta que todos los hombres de la familia han tenido desde siempre ese don, el de regresar en el tiempo a un momento determinado, una y otra vez, hasta conseguir hacer \"lo correcto\". Así pues, Tim decide volver al pasado para intentar conquistar a Mary (Rachel McAdams), la chica de sus sueños.', '2013', '123 min', 'Richard Curtis', 'Reino Unido'),
(64, 'Con faldas y a lo loco', 'img_684aa81eb869c.jpg', 'Época de la Ley Seca (1920-1933). Joe y Jerry son dos músicos del montón que se ven obligados a huir después de ser testigos de un ajuste de cuentas entre dos bandas rivales. Como no encuentran trabajo y la mafia los persigue, deciden vestirse de mujeres y tocar en una orquesta femenina. Joe (Curtis) para conquistar a Sugar Kane (Monroe), la cantante del grupo, finge ser un magnate impotente; mientras tanto, Jerry (Lemmon) es cortejado por un millonario que quiere casarse con él.', '1959', '120 min', 'Billy Wilder', 'Estados Unidos'),
(65, 'Resacón en Las Vegas', 'img_684aa845ad44e.jpg', 'Historia de una desmadrada despedida de soltero en la que el novio y tres amigos se montan una gran juerga en Las Vegas. Como era de esperar, a la mañana siguiente tienen una resaca tan monumental que no pueden recordar nada de lo ocurrido la noche anterior. Lo más extraordinario es que el novio ha desaparecido y en la suite del hotel se encuentran un tigre y un bebé.', '2009', '100 min', 'Todd Phillips', 'Estados Unidos'),
(66, 'Mejor... imposible', 'img_684aa86fe65b1.jpg', 'Melvin Udall (Jack Nicholson), un escritor maniático que padece un trastorno obsesivo-compulsivo, es el ser más desagradable y desagradecido que uno pueda tener como vecino en Nueva York. Entre sus rutinas está la de comer todos los días en una cafetería, donde le sirve Carol Connelly (Helen Hunt), camarera y madre soltera. Simon Nye (Greg Kinnear), un artista gay que vive en el apartamento contiguo al de Melvin, sufre constantemente su homofobia. De repente, un buen día, Melvin tiene que hacerse cargo de un pequeño perro aunque detesta los animales. La compañía del animal contribuirá a suavizar su carácter.', '1997', '138 min', 'James L. Brooks', 'Estados Unidos'),
(67, 'Bienvenidos al Norte', 'img_684aa8912ba96.jpg', 'Phillippe Abrams (Kad Merad) es un funcionario de Correos al que destinan, en contra de su voluntad, a Bergues, un pueblecito en la frontera con Bélgica. Aunque, cuando llega allí, se encuentra con un lugar idílico y gentes encantadoras, a su mujer (Zoé Félix) le asegura que vive en un auténtico infierno. Obtuvo un enorme éxito de taquilla en Francia y fue la cinta francesa más taquillera de Bélgica.', '2008', '106 min', 'Dany Boon', 'Francia'),
(68, 'Scary Movie', 'img_684aa8b66401e.jpg', 'Una bella estudiante muere asesinada. Un grupo de desorientados adolescentes descubre que entre ellos hay un asesino. La heroína Cyndi Campbell y su grupo de despistados amigos se verán aterrorizados por un singular psicópata enmascarado que pretende vengarse de ellos, después de que lo atropellaran por accidente el pasado Halloween.', '2000', '88 min', 'Keenen Ivory Wayans', 'Estados Unidos'),
(69, 'Los cazafantasmas', 'img_684aa94640cd5.jpg', 'A los doctores Venkman, Stantz y Spengler, expertos en parapsicología, no les conceden una beca de investigación que habían solicitado. Al encontrarse sin trabajo, deciden fundar la empresa \"Los Cazafantasmas\", dedicada a limpiar Nueva York de ectoplasmas. El aumento repentino de apariciones espectrales en la ciudad será el presagio de la llegada de un peligroso y poderoso demonio.', '1984', '107 min', 'Ivan Reitman', 'Estados Unidos'),
(70, 'Dr. Dolittle', 'img_684aa96ba3a33.jpg', 'John Dolittle es un peculiar veterinario que tiene el don de comprender lo que dicen los animales. Mientras su consulta se desborda de mascotas de toda especie, sus colegas piensan que se ha vuelto loco de remate. Una taquillera comedia realizada a mayor gloria de Mr. Murphy. Remake de \"El extravagante Dr. Dolittle\" con Rex Harrison como protagonista.', '1998', '85 min', 'Betty Thomas', 'Estados Unidos'),
(71, 'American Pie', 'img_684aa996e5622.jpg', 'Una legión de jóvenes inexpertos viven obsesionados con el sexo opuesto. Jim, uno de ellos, está desesperado porque todavía es virgen. Además, desde que sus padres le sorprendieron viendo películas pornográficas, su situación en casa ha empeorado, porque su bienintencionado padre pretende ocuparse de su educación sexual; en el colegio, las cosas no van mucho mejor: su relación con una chica, gracias a un programa de intercambio, tiene toda la pinta de fracasar. Así que su último recurso se llama Michelle, una integrante de la banda de música que resulta ser todo un prodigio', '1999', '1999', 'Paul Weitz, Chris Weitz', 'Estados Unidos'),
(72, 'El rey león', 'img_684aaae620905.jpg', 'La sabana africana es el escenario en el que tienen lugar las aventuras de Simba, un pequeño león que es el heredero del trono. Sin embargo, al ser injustamente acusado por el malvado Scar de la muerte de su padre, se ve obligado a exiliarse. Durante su destierro, hará buenas amistades e intentará regresar para recuperar lo que legítimamente le corresponde.', '1994', '85 min', 'Rob Minkoff, Roger Allers', 'Estados Unidos'),
(73, 'Del revés (Inside Out)', 'img_684aab533800f.jpg', 'Riley es una chica que disfruta o padece toda clase de sentimientos. Aunque su vida ha estado marcada por la Alegría, también se ve afectada por otro tipo de emociones. Lo que Riley no entiende muy bien es por qué motivo tiene que existir la Tristeza en su vida. Una serie de acontecimientos hacen que Alegría y Tristeza se mezclen en una peligrosa aventura que dará un vuelco al mundo de Riley.', '2015', '94 min', 'Pete Docter, Ronaldo Del Carmen', 'Estados Unidos'),
(74, 'El viaje de Chihiro', 'img_684aab84c9df2.jpg', 'Chihiro es una niña de diez años que viaja en coche con sus padres. Después de atravesar un túnel, llegan a un mundo fantástico, en el que no hay lugar para los seres humanos, sólo para los dioses de primera y segunda clase. Cuando descubre que sus padres han sido convertidos en cerdos, Chihiro se siente muy sola y asustada.', '2001', '124 min', 'Hayao Miyazaki', 'Japón'),
(75, 'Up', 'img_684aabacdd474.jpg', 'Carl Fredricksen es un viudo vendedor de globos de 78 años que, finalmente, consigue llevar a cabo el sueño de su vida: enganchar miles de globos a su casa y salir volando rumbo a América del Sur. Pero ya estando en el aire y sin posibilidad de retornar Carl descubre que viaja acompañado de Russell, un explorador que tiene ocho años y un optimismo a prueba de bomba.', '2009', '96 min', 'Pete Docter, Bob Peterson', 'Estados Unidos'),
(76, 'WALL•E', 'img_684aadfbd85db.jpg', 'En el año 2800, en un planeta Tierra devastado y sin vida, tras cientos de solitarios años haciendo aquello para lo que fue construido -limpiar el planeta de basura- el pequeño robot WALL•E (acrónimo de Waste Allocation Load Lifter Earth-Class) descubre una nueva misión en su vida (además de recolectar cosas inservibles) cuando se encuentra con una moderna y lustrosa robot exploradora llamada EVE. Ambos viajarán a lo largo de la galaxia y vivirán una emocionante e inolvidable aventura...', '2008', '103 min', 'Andrew Stanton', 'Estados Unidos'),
(77, 'Persépolis', 'img_684ab0396e7eb.jpg', 'Narra la conmovedora historia de una niña iraní desde la revolución islámica hasta nuestros días. Cuando los fundamentalistas toman el poder, forzando a las mujeres a llevar velo y encarcelando a miles de personas, y mientras tiene lugar la guerra entre Irak e Irán, Marjane descubre el punk, ABBA y Iron Maiden. Cuando llega a la adolescencia sus padres la envían a Europa, donde conoce otra cultura que nada tiene que ver con la de su país. La protagonista se adapta bien a su nueva vida, pero no soporta la soledad y vuelve con su familia, aunque eso signifique ponerse el velo y someterse a una sociedad tiránica. Voces originales en francés de Catherine Deneuve y Chiara Mastroianni.', '2007', '95 min', 'Marjane Satrapi, Vincent Paronnaud', 'Francia'),
(78, 'Pesadilla antes de Navidad', 'img_684ab0676457f.jpg', 'Cuando Jack Skellington, el Señor de Halloween, descubre la Navidad, se queda fascinado y decide mejorarla. Sin embargo, su visión de la festividad es totalmente contraria al espíritu navideño. Sus planes incluyen el secuestro de Santa Claus y la introducción de cambios bastante macabros. Sólo su novia Sally es consciente del error que está cometiendo.', '1993', '75 min', 'Henry Selick', 'Estados Unidos'),
(79, 'Los Increíbles', 'img_684ab09795f18.jpg', 'Bob Parr era uno de los más grandes superhéroes del mundo (también se le conocía como \"Mr. Increíble\"), salvaba vidas y luchaba contra villanos a diario. Han pasado 15 años, y Bob y su mujer (una famosa ex-superheroína por derecho propio) han adoptado una identidad civil y se han retirado a la periferia para llevar una vida normal con sus tres hijos. Bob se dedica a comprobar los plazos de las reclamaciones de seguros y lucha contra el aburrimiento y los michelines. Está deseando volver a entrar en acción, así que cuando recibe una misteriosa comunicación que le ordena dirigirse a una remota isla para cumplir una misión de alto secreto, no se lo piensa dos veces.', '2004', '115 min', 'Brad Bird', 'Estados Unidos'),
(80, 'Los Simpson: ¿Quién disparó al Sr. Burns?', 'img_684ab0ba194c3.jpg', 'La Escuela Primaria de Springfield encuentra petróleo, pero el Sr. Burns lo roba y al mismo tiempo arruina las vidas de varios ciudadanos de Springfield, llevando a cabo su plan de ocultar el sol para enriquecerse con la central eléctrica. Todo esto motiva que Burns reciba un disparo de un atacante desconocido, iniciándose una investigación policial para encontrar al culpable de ese acto.', '1995', '44 min', 'Jeffrey Lynch, Wesley Archer', 'Estados Unidos'),
(81, 'Frozen. El reino del hielo', 'img_684ab0f80dd17.jpg', 'Cuando una profecía condena a un reino a vivir un invierno eterno, la joven Anna, el temerario montañero Kristoff y el reno Sven emprenden un viaje épico en busca de Elsa, hermana de Anna y Reina de las Nieves, para poner fin a un gélido hechizo... Adaptación libre del cuento \"La reina de las nieves\".', '2013', '98 min', 'Chris Buck, Jennifer Lee', 'Estados Unidos'),
(82, 'Mad Max: Furia en la carretera', 'img_684ab16866196.jpg', 'Perseguido por su turbulento pasado, Mad Max cree que la mejor forma de sobrevivir es ir solo por el mundo. Sin embargo, se ve arrastrado a formar parte de un grupo que huye a través del desierto en un War Rig conducido por una Emperatriz de élite: Furiosa. Escapan de una Ciudadela tiranizada por Immortan Joe, a quien han arrebatado algo irreemplazable. Enfurecido, el Señor de la Guerra moviliza a todas sus bandas y persigue implacablemente a los rebeldes en una \"guerra de la carretera\" de altas revoluciones... Cuarta entrega de la saga post-apocalíptica que resucita la trilogía que a principios de los ochenta protagonizó Mel Gibson.', '2015', '120 min', 'George Miller', 'Australia'),
(83, 'El caballero oscuro: La leyenda renace', 'img_684ab19c4232e.jpg', 'Hace ocho años que Batman desapareció, dejando de ser un héroe para convertirse en un fugitivo. Al asumir la culpa por la muerte del fiscal del distrito Harvey Dent, el Caballero Oscuro decidió sacrificarlo todo por lo que consideraba, al igual que el Comisario Gordon, un bien mayor. La mentira funciona durante un tiempo, ya que la actividad criminal de la ciudad de Gotham se ve aplacada gracias a la dura Ley Dent. Pero todo cambia con la llegada de una astuta gata ladrona que pretende llevar a cabo un misterioso plan. Sin embargo, mucho más peligrosa es la aparición en escena de Bane, un terrorista enmascarado cuyos despiadados planes obligan a Bruce a regresar de su voluntario exilio.', '2012', '164 min', 'Christopher Nolan', 'Estados Unidos'),
(84, 'Jungla de cristal', 'img_684ab1cb3bf9f.jpg', 'En lo alto de la ciudad de Los Ángeles, un grupo terrorista se ha apoderado de un edificio tomando a un grupo de personas como rehenes. Sólo un hombre, el policía de Nueva York John McClane (Bruce Willis), ha conseguido escapar del acoso terrorista. Aunque está solo y fuera de servicio, McClane se enfrentará a los secuestradores. Él es la única esperanza para los rehenes.', '1988', '131 min', 'John McTiernan', 'Estados Unidos'),
(85, 'Acorralado (Rambo)', 'img_684ab1f599632.jpg', 'Cuando John Rambo, un veterano boina verde, va a visitar a un viejo compañero de armas, se entera de que ha muerto víctima de las secuelas de la guerra. Algunos días después, la policía lo detiene por vagabundo y se ensaña con él. Entonces recuerda las torturas que sufrió en Vietnam y reacciona violentamente.', '1982', '97 min', 'Ted Kotcheff', 'Estados Unidos'),
(86, 'Matrix', 'img_684ab21fa3021.jpg', 'Thomas Anderson es un brillante programador de una respetable compañía de software. Pero fuera del trabajo es Neo, un hacker que un día recibe una misteriosa visita...', '1999', '131 min', 'Lilly Wachowski, Lana Wachowski, Hermanas Wachowski', 'Estados Unidos'),
(87, 'Speed: Máxima potencia', 'img_684ab2474612c.jpg', 'Jack Traven (Reeves) es un intrépido policía de Los Ángeles. Sobrevivir en esta ciudad no es nada fácil para un agente de la ley, pero Jack, además de disfrutar de una proverbial buena suerte, conoce perfectamente los trucos para sortear el peligro. Tendrá, sin embargo, que afrontar una dura prueba cuando queda atrapado en un autobús urbano que lleva instalada una bomba programada para explotar si el vehículo disminuye su velocidad a menos de 80 kilómetros por hora. Empieza así una loca carrera por la ciudad, con Jack intentando dar confianza a la joven pasajera (Bullock) que ha sustituido al conductor, herido por los secuestradores.', '1994', '115 min', 'Jan de Bont', 'Estados Unidos'),
(88, 'El mito de Bourne', 'img_684ab27bb9549.jpg', 'Jason Bourne pensaba que había dejado atrás su pasado dos años antes. Durante ese tiempo, atormentado por un pasado que no consigue recordar, Bourne y Marie se trasladan de una ciudad a otra, viviendo de manera anónima y clandestina. Tratan de huir de una amenaza que creen percibir en la mirada de cualquier extraño, en cada llamada telefónica \"equivocada\". Cuando un agente aparece por la tranquila villa en la que se alojan, la pareja huye precipitadamente. Pero el juego del ratón y el gato ha vuelto a comenzar, obligando a entrar en acción a Bourne para enfrentarse a un grupo de implacables asesinos profesionales.', '2004', '108 min', 'Paul Greengrass', 'Estados Unidos'),
(89, 'Iron Man', 'img_684ab2a94b4e2.jpg', 'El multimillonario fabricante de armas Tony Stark (Robert Downey Jr.) debe enfrentarse a su turbio pasado después de sufrir un accidente con una de sus armas. Equipado con una armadura de última generación tecnológica, se convierte en \"El hombre de hierro\", un héroe que se dedica a combatir el mal en todo el mundo.', '2008', '126 min', 'Jon Favreau', 'Estados Unidos'),
(90, 'Casino Royale', 'img_684ab2df629cf.jpg', 'La primera misión del agente británico James Bond (Daniel Craig) como agente 007 lo lleva hasta Le Chiffre (Mads Mikkelsen), banquero de los terroristas de todo el mundo. Para detenerlo y desmantelar la red terrorista, Bond debe derrotarlo en una arriesgada partida de póquer en el Casino Royale. Al principio a Bond le disgusta Vesper Lynd (Eva Green), la hermosa oficial del Tesoro que debe vigilar el dinero del gobierno. Pero, a medida que Bond y Vesper se ven obligados a defenderse juntos de los mortales ataques de Le Chiffre y sus secuaces, nace entre ellos una atracción mutua.', '2006', '144 min', 'Martin Campbell', 'Reino Unido'),
(91, 'En busca del arca perdida', 'img_684ab319dc24e.jpg', 'Año 1936. Indiana Jones es un profesor de arqueología, dispuesto a correr peligrosas aventuras con tal de conseguir valiosas reliquias históricas. Después de una infructuosa misión en Sudamérica, el gobierno estadounidense le encarga la búsqueda del Arca de la Alianza, donde se conservan las Tablas de la Ley que Dios entregó a Moisés. Según la leyenda, quien las posea tendrá un poder absoluto, razón por la cual también la buscan los nazis.', '1981', '115 min', 'Steven Spielberg', 'Estados Unidos'),
(92, 'El renacido', 'img_684ab3497c2cc.jpg', 'Año 1823. En las profundidades de la América salvaje, el explorador Hugh Glass (Leonardo DiCaprio) participa junto a su hijo mestizo Hawk en una expedición de tramperos que recolecta pieles. Glass resulta gravemente herido por el ataque de un oso y es abandonado a su suerte por un traicionero miembro de su equipo, John Fitzgerald (Tom Hardy). Con la fuerza de voluntad como su única arma, Glass deberá enfrentarse a un territorio hostil, a un invierno brutal y a la guerra constante entre las tribus de nativos americanos, en una búsqueda implacable para conseguir vengarse.', '2015', '156 min', 'Alejandro González Iñárritu', 'Estados Unidos'),
(93, 'La guerra de las galaxias. Episodio IV: Una nueva esperanza', 'img_684ab37d374b4.jpg', 'La princesa Leia, líder del movimiento rebelde que desea reinstaurar la República en la galaxia en los tiempos ominosos del Imperio, es capturada por las Fuerzas Imperiales, capitaneadas por el implacable Darth Vader, el sirviente más fiel del Emperador. El intrépido y joven Luke Skywalker, ayudado por Han Solo, capitán de la nave espacial \"El Halcón Milenario\", y los androides, R2D2 y C3PO, serán los encargados de luchar contra el enemigo e intentar rescatar a la princesa para volver a instaurar la justicia en el seno de la galaxia.', '1977', '121 min', 'George Lucas', 'Estados Unidos'),
(94, 'La guerra de las galaxias. Episodio V: El imperio contraataca', 'img_684ab3a150fa8.jpg', 'Tras un ataque sorpresa de las tropas imperiales a las bases camufladas de la alianza rebelde, Luke Skywalker, en compañía de R2D2, parte hacia el planeta Dagobah en busca de Yoda, el último maestro Jedi, para que le enseñe los secretos de la Fuerza. Mientras, Han Solo, la princesa Leia, Chewbacca, y C3PO esquivan a las fuerzas imperiales y piden refugio al antiguo propietario del Halcón Milenario, Lando Calrissian, en la ciudad minera de Bespin, donde les prepara una trampa urdida por Darth Vader.', '1980', '124 min', 'Irvin Kershner', 'Estados Unidos'),
(95, 'La guerra de las galaxias. Episodio VI: El retorno del Jedi', 'img_684ab3c65f5cc.jpg', 'Para ir a Tatooine y liberar a Han Solo, Luke Skywalker y la princesa Leia deben infiltrarse en la peligrosa guarida de Jabba the Hutt, el gángster más temido de la galaxia. Una vez reunidos, el equipo recluta a tribus de Ewoks para combatir a las fuerzas imperiales en los bosques de la luna de Endor. Mientras tanto, el Emperador y Darth Vader conspiran para atraer a Luke al lado oscuro, pero el joven está decidido a reavivar el espíritu del Jedi en su padre. La guerra civil galáctica termina con un último enfrentamiento entre las fuerzas rebeldes unificadas y una segunda Estrella de la Muerte, indefensa e incompleta, en una batalla que decidirá el destino de la galaxia.', '1983', '133 min', 'Richard Marquand', 'Estados Unidos'),
(96, 'Avatar', 'img_684ab3eabdc7e.jpg', 'Año 2154. Jake Sully (Sam Worthington), un ex-marine condenado a vivir en una silla de ruedas, sigue siendo, a pesar de ello, un auténtico guerrero. Precisamente por ello ha sido designado para ir a Pandora, donde algunas empresas están extrayendo un mineral extraño que podría resolver la crisis energética de la Tierra. Para contrarrestar la toxicidad de la atmósfera de Pandora, se ha creado el programa Avatar, gracias al cual los seres humanos mantienen sus conciencias unidas a un avatar: un cuerpo biológico controlado de forma remota que puede sobrevivir en el aire letal. Esos cuerpos han sido creados con ADN humano, mezclado con ADN de los nativos de Pandora, los Na\'vi. Convertido en avatar, Jake puede caminar otra vez. Su misión consiste en infiltrarse entre los Na\'vi, que se han convertido en el mayor obstáculo para la extracción del mineral. Pero cuando Neytiri, una bella Na\'vi (Zoe Saldana), salva la vida de Jake, todo cambia: Jake, tras superar ciertas pruebas, es admitido en su clan. Mientras tanto, los hombres esperan los resultados de la misión de Jake.', '2009', '161 min', 'James Cameron', 'Estados Unidos'),
(97, 'E.T. el extraterrestre', 'img_684ab41111920.jpg', 'Un pequeño ser de otro planeta se queda abandonado en la Tierra cuando su nave, al emprender el regreso, se olvida de él. Está completamente solo y tiene miedo, pero se hará amigo de un niño, que lo esconde en su casa. El pequeño y sus hermanos intentan encontrar la forma de que el pequeño extraterrestre regrese a su planeta antes de que lo encuentren los científicos y la policía.', '1982', '115 min', 'Steven Spielberg', 'Estados Unidos'),
(98, 'Akira', 'img_684ab439e9921.jpg', 'Año 2019. Neo-Tokyo es una ciudad construida sobre las ruinas de la antigua capital japonesa destruida tras la Tercera Guerra Mundial. Japón es un país al borde del colapso que sufre continuas crisis políticas. En secreto, un equipo de científicos ha reanudado por orden del ejército un experimento para encontrar a individuos que puedan controlar el arma definitiva: una fuerza denominada \"la energía absoluta\". Pero los habitantes de Neo-Tokyo tienen otras cosas de las que preocuparse. Uno de ellos es Kaneda, un joven pandillero líder de una banda de motoristas. Durante una pelea, su mejor amigo, Tetsuo, sufre un extraño accidente y termina ingresado en unas instalaciones militares. Allí los científicos descubrirán que es el poseedor de la energía absoluta. Pero Tetsuo, que no se resigna a convertirse en un conejillo de indias, muy pronto se convertirá en la amenaza más grande que el mundo ha conocido.', '1988', '124 min', 'Katsuhiro Ōtomo', 'Japón');
INSERT INTO `peliculas` (`id`, `titulo`, `portada`, `sipnopsis`, `anho`, `duracion`, `director`, `pais`) VALUES
(99, 'Blade Runner', 'img_684ab46746f3a.jpg', 'Noviembre de 2019. A principios del siglo XXI, la poderosa Tyrell Corporation creó, gracias a los avances de la ingeniería genética, un robot llamado Nexus 6, un ser virtualmente idéntico al hombre pero superior a él en fuerza y agilidad, al que se dio el nombre de Replicante. Estos robots trabajaban como esclavos en las colonias exteriores de la Tierra. Después de la sangrienta rebelión de un equipo de Nexus-6, los Replicantes fueron desterrados de la Tierra. Brigadas especiales de policía, los Blade Runners, tenían órdenes de matar a todos los que no hubieran acatado la condena. Pero a esto no se le llamaba ejecución, se le llamaba \"retiro\". Tras un grave incidente, el ex Blade Runner Rick Deckard es llamado de nuevo al servicio para encontrar y \"retirar\" a unos replicantes rebeldes.', '1982', '117 min', 'Ridley Scott', 'Estados Unidos'),
(100, 'Origen', 'img_684ab48bd8177.jpg', 'Dom Cobb (DiCaprio) es un experto en el arte de apropiarse, durante el sueño, de los secretos del subconsciente ajeno. La extraña habilidad de Cobb le ha convertido en un hombre muy cotizado en el mundo del espionaje, pero también lo ha condenado a ser un fugitivo y, por consiguiente, a renunciar a llevar una vida normal. Su única oportunidad para cambiar de vida será hacer exactamente lo contrario de lo que ha hecho siempre: la incepción, que consiste en implantar una idea en el subconsciente en lugar de sustraerla. Sin embargo, su plan se complica debido a la intervención de alguien que parece predecir cada uno de sus movimientos, alguien a quien sólo Cobb podrá descubrir.', '2010', '148 min', 'Christopher Nolan', 'Estados Unidos'),
(101, 'Soy leyenda', 'img_684ab4bce650e.jpg', 'Año 2012. Robert Neville (Will Smith) es el último hombre vivo que hay sobre la Tierra, pero no está solo. Los demás seres humanos se han convertido en vampiros y todos ansían beber su sangre. Durante el día vive en estado de alerta, como un cazador, y busca a los muertos vivientes mientras duermen; pero durante la noche debe esconderse de ellos y esperar el amanecer. Esta pesadilla empezó hace tres años: Neville era un brillante científico, pero no pudo impedir la expansión de un terrible virus creado por el hombre. Él ha sobrevivido porque es inmune al virus; todos los días envía mensajes por radio con la esperanza de que haya otros supervivientes, pero es inútil. Lo único que puede hacer es buscar una fórmula que le permita utilizar su sangre inmune para devolverles a los hombres su naturaleza. Pero está en inferioridad de condiciones y el tiempo se acaba.', '2007', '100 min', 'Francis Lawrence', 'Estados Unidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_genero`
--

CREATE TABLE `pelicula_genero` (
  `pelicula_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_genero`
--

INSERT INTO `pelicula_genero` (`pelicula_id`, `genero_id`) VALUES
(13, 1),
(13, 4),
(13, 5),
(14, 1),
(14, 4),
(14, 7),
(15, 1),
(15, 3),
(15, 5),
(15, 7),
(16, 2),
(16, 3),
(16, 4),
(17, 3),
(17, 4),
(17, 5),
(17, 7),
(18, 3),
(19, 3),
(20, 4),
(20, 7),
(21, 3),
(21, 7),
(22, 3),
(23, 3),
(24, 1),
(24, 4),
(24, 5),
(24, 7),
(25, 3),
(25, 7),
(26, 3),
(27, 3),
(28, 6),
(29, 6),
(30, 6),
(31, 5),
(31, 6),
(32, 6),
(33, 3),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 6),
(41, 3),
(41, 6),
(42, 6),
(43, 3),
(43, 6),
(44, 3),
(44, 6),
(45, 5),
(45, 6),
(46, 1),
(46, 6),
(47, 6),
(48, 2),
(48, 8),
(49, 2),
(49, 3),
(49, 8),
(50, 2),
(50, 8),
(51, 2),
(51, 8),
(52, 2),
(52, 8),
(53, 2),
(53, 8),
(54, 2),
(54, 3),
(54, 8),
(55, 2),
(55, 8),
(56, 2),
(56, 3),
(56, 8),
(57, 2),
(57, 8),
(58, 2),
(58, 8),
(59, 2),
(59, 8),
(61, 2),
(61, 3),
(61, 8),
(62, 2),
(62, 8),
(63, 2),
(63, 8),
(64, 2),
(65, 2),
(66, 2),
(66, 3),
(66, 8),
(67, 2),
(68, 2),
(68, 6),
(69, 2),
(69, 6),
(70, 2),
(71, 2),
(72, 2),
(72, 3),
(72, 4),
(72, 7),
(73, 2),
(73, 4),
(73, 7),
(74, 4),
(74, 7),
(75, 2),
(75, 4),
(75, 7),
(76, 4),
(76, 5),
(76, 7),
(76, 8),
(77, 3),
(77, 4),
(78, 4),
(79, 1),
(79, 2),
(79, 4),
(79, 7),
(80, 4),
(81, 2),
(81, 4),
(81, 7),
(82, 1),
(82, 5),
(83, 1),
(83, 3),
(84, 1),
(85, 1),
(86, 1),
(86, 5),
(87, 1),
(88, 1),
(89, 1),
(89, 5),
(89, 7),
(90, 1),
(91, 1),
(91, 7),
(92, 7),
(93, 5),
(93, 7),
(94, 1),
(94, 5),
(94, 7),
(95, 1),
(95, 5),
(95, 7),
(96, 1),
(96, 5),
(96, 7),
(96, 8),
(97, 3),
(97, 5),
(98, 1),
(98, 4),
(98, 5),
(99, 1),
(99, 5),
(100, 1),
(100, 5),
(101, 1),
(101, 5),
(101, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(150) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `rol`) VALUES
(1, 'userPrueba', 'prueba1@gmail.com', '$2y$10$SDsnUu8YCCBPZm8QQbDw0exmPRQH1Wb4ow5tAyWIbr7cyzb2qOqHy', 2),
(2, 'admin', 'admin@gmail.com', '$2y$10$gEkGpKjwahinK3Eixc0x3utnJ1RfP078sbyP2R4lV4IVct8xOVrya', 1),
(3, 'Usuario2', 'user2@gmail.com', '$2y$10$RRZcTILzCuklS5Esw82yV.sje4TKN08hGCS1YwuGUK/jLdWpxLxhy', 2),
(4, 'user3', 'user3@gmail.com', '$2y$10$Kzj38rDCrX5uA9CvuzPHPen1VJtdwURQSvZh1A5DK3PcLiMxVt1Ky', 2),
(5, 'Tomas Macias', 'tomas@gmail.com', '$2y$10$gqlWrXvdLVLQpUi1EKuZPujQ4tsSNHvTQrigYS6odubwdJpEnHaF2', 2),
(6, 'Rodrigo Martinez', 'rodrigo@gmail.com', '$2y$10$DoOmWrOXZZU9ARnS7fBXueS.2QQ8g/nw9PVh2iq7C6iu2cBGv8rKO', 2),
(7, 'Jaime Mellado', 'jaime@gmail.com', '$2y$10$Vn.kyvV8CpQ0wWGc6RR3heybu86Ux4sqz.T.HNFA3hV3eRXxk/vtW', 2),
(8, 'Xavier Lugo', 'xavier@gmail.com', '$2y$10$vSwkjXr2UQKlorxpCdiI9.eeQYGWug9Zlqdb/7n1UaNZ.4an67rBy', 2),
(13, 'Harold Xavier', 'harold@gmail.com', '$2y$10$z5KeClx/9UI6eHad9U4FReokUO2j22DwLjTRmaD8niEfk9B0IjATO', 2),
(14, 'Ruben Casas', 'ruben@gmail.com', '$2y$10$MYyvvrdx6hNO0khx/Ipw6O5wB6bG0TVZN2V1mscXu2vB2RAaAFFb6', 2),
(15, 'Jose Iglesias', 'jose@gmail.com', '$2y$10$67A/BQhy2KNwz5rwslYDoeDDBZjN1Z55voh0QGY4UlL8O.P/zA9DO', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pelicula_id` int(11) NOT NULL,
  `puntuacion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id`, `user_id`, `pelicula_id`, `puntuacion`) VALUES
(4, 5, 92, 9),
(5, 5, 74, 8),
(6, 5, 75, 7),
(7, 5, 76, 9),
(8, 5, 26, 8),
(9, 5, 98, 9),
(10, 5, 99, 7),
(11, 5, 101, 8),
(12, 6, 99, 8),
(13, 6, 101, 9),
(14, 6, 74, 10),
(15, 6, 26, 7),
(16, 6, 98, 8),
(17, 6, 92, 10),
(18, 6, 76, 9),
(19, 7, 92, 9),
(20, 7, 81, 6),
(21, 7, 80, 7),
(22, 7, 15, 6),
(23, 7, 14, 6),
(24, 7, 13, 6),
(25, 7, 75, 8),
(26, 7, 99, 8),
(27, 7, 26, 8),
(28, 7, 101, 9),
(29, 7, 98, 9),
(30, 7, 76, 10),
(31, 7, 74, 7),
(32, 2, 98, 8),
(33, 5, 95, 6),
(34, 5, 96, 7),
(35, 5, 97, 8),
(36, 5, 94, 7),
(37, 5, 93, 8),
(38, 5, 91, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `pelicula_id` (`pelicula_id`) USING BTREE;

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_genero_nombre` (`nombre`);

--
-- Indices de la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_pelicula` (`user_id`,`pelicula_id`),
  ADD KEY `fk_ml_user` (`user_id`),
  ADD KEY `fk_ml_pelicula` (`pelicula_id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula_genero`
--
ALTER TABLE `pelicula_genero`
  ADD PRIMARY KEY (`pelicula_id`,`genero_id`),
  ADD KEY `fk_pg_genero` (`genero_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_rol` (`rol`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `pelicula_id` (`pelicula_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_peliculac_id` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`);

--
-- Filtros para la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD CONSTRAINT `fk_ml_pelicula` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ml_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pelicula_genero`
--
ALTER TABLE `pelicula_genero`
  ADD CONSTRAINT `fk_pg_genero` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pg_pelicula` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_rol` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `fk_pelicula_id` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

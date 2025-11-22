# TP_AsusTech

## integrantes del grupo

- Planes Mateo Valentín - mateo62009mp@gmail.com
- Ramos Thiago - tr9282321@yahoo.com

---

## tematica del tpe

Venta de Notebooks ASUS

---

La API permite:

- Listar, crear, editar y eliminar *computadoras* (notebooks ASUS).
- Administrar *categorías*.
- Administrar *ofertas*.
- Asociar *notebooks a ofertas* con un precio con descuento.

---

## EXPLICACIÓN DE ENDPOINTS Y EJEMPLOS

- http://localhost/ASUS-tech-api/api/computadoras?orderBy=ASC&limit=2 permite tanto como de forma ASC o DESC poder ordenar las computadoras y ademas limitar cuantas computadoras obtener
- http://localhost/ASUS-tech-api/api/computadoras/:id permite obtener una computadora especifica y tambien sirve para editar y borrar
- http://localhost/ASUS-tech-api/api/computadoras permite para obtener y agregar

- http://localhost/ASUS-tech-api/api/categorias permite obtener y crear categorias para las computadoras
- http://localhost/ASUS-tech-api/api/categorias/:id permite obtener una categoria especifica y tambien sirve para editar y borrar

- http://localhost/ASUS-tech-api/api/ofertas permite obtener y crear una oferta para mostrar el tipo de oferta vigente
- http://localhost/ASUS-tech-api/api/ofertas:id permite obtener una oferta especifica y tambien sirve para editar y borrar

- http://localhost/ASUS-tech-api/api/ofertasComputadoras permite obtener las computadoras que se encuentra en oferta
- http://localhost/ASUS-tech-api/api/ofertasComputadoras/:id permite obtener una computadora escifica en la oferta 
- http://localhost/ASUS-tech-api/api/ofertas/:idOferta/computadoras/:idComputadora permite agregar , actualizar y eliminar las computadoras que se encuentra en la oferta

---

## Descripción del dominio

- *se agregaron dos tablas nuevas a la base de datos original que son ofertas y oferta_notebook*

- La aplicación modela un sistema donde los usuarios pueden ver y administrar notebooks ASUS, clasificadas en categorías y asociadas a distintas ofertas.
- Cada notebook pertenece a una sola categoría (Gaming, Oficina, Estudio)
- Una categoría puede tener muchas notebooks asociadas
- Cada oferta puede incluir varias notebooks mediante la tabla intermedia oferta_notebooks
- Una notebook puede estar como máximo en una oferta 
- Para cada relación oferta–notebook se guarda un precio de descuento específico.

const express = require('express');
const { Sequelize, DataTypes } = require('sequelize');

const app = express();
const port = 8080;

const sequelize = new Sequelize('prueba', 'root', '1234', {
  host: 'mysql', // Nombre del servicio MySQL en el archivo docker-compose.yml
  dialect: 'mysql',
  port: '3306'
});

const Alumno = sequelize.define('alumnos', {
  apellidos: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  nombres: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  dni: {
    type: DataTypes.STRING,
    allowNull: false,
  }
},
{
  timestamps: false
});

sequelize.sync();

app.use(express.urlencoded({ extended: true }));

app.get('/', async (req, res) => {
  try {
    const alumnos = await Alumno.findAll();
    res.send(`
      <h2>Consulta de Alumnos</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Apellidos</th>
          <th>Nombres</th>
          <th>DNI</th>
        </tr>
        ${alumnos.map((alumno) => `
          <tr>
            <td>${alumno.id}</td>
            <td>${alumno.apellidos}</td>
            <td>${alumno.nombres}</td>
            <td>${alumno.dni}</td>
            <td>
              <form method="post" action="/delete/${alumno.id}">
                <button type="submit">Eliminar</button>
              </form>
            </td>
          </tr>
        `).join('')}
      </table>
      <h2>Insertar Nuevo Alumno</h2>
      <form method="post" action="/insert">
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br><br>
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required><br><br>
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br><br>
        <input type="submit" value="Insertar Alumno">
      </form>
    `);
  } catch (error) {
    console.error('Error al obtener la lista de alumnos: ' + error.message);
    res.status(500).send('Error al consultar la base de datos');
  }
});

app.post('/insert', async (req, res) => {
  try {
    const { apellidos, nombres, dni } = req.body;
    await Alumno.create({ apellidos, nombres, dni });
    console.log('Alumno insertado con éxito');
    res.redirect('/');
  } catch (error) {
    console.error('Error al insertar alumno: ' + error.message);
    res.status(500).send('Error al insertar en la base de datos');
  }
});

// Agrega un nuevo endpoint para eliminar un alumno
app.post('/delete/:id', async (req, res) => {
    try {
      const alumnoId = req.params.id;
      const alumno = await Alumno.findByPk(alumnoId);
      
      if (!alumno) {
        res.status(404).send('Alumno no encontrado');
        return;
      }
  
      await alumno.destroy();
      console.log('Alumno eliminado con éxito');
      res.redirect('/');
    } catch (error) {
      console.error('Error al eliminar alumno: ' + error.message);
      res.status(500).send('Error al eliminar en la base de datos');
    }
  });

app.listen(port, () => {
  console.log(`Servidor Express escuchando en el puerto ${port}`);
});
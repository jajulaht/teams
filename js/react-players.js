class Row extends React.Component {
  render () {
    return (
          <li>
            <a href={ 'player.php?p_id=' + this.props.p_id }>
              <strong>{this.props.sname}, {this.props.fname},</strong> {this.props.number}
            </a>
          </li>
    );
  }
}

class Players extends React.Component {
  render () {  
    // Loop through the list of players and create array of Row components
    let Rows = this.props.players.map(function(player, index) {
      return (
        <Row  key={index} 
              p_id={player.p_id}
              sname={player.p_sname} 
              fname={player.p_fname} 
              number={player.p_number} 
              
        />
      )
    });
    
    return (
        <ul>
          {Rows}
        </ul>
    );
  }
}

class PlayersFooter extends React.Component {
  constructor(props) {
    super(props);
    this.state = {fname: '',
                  sname: '',
                  number: ''
                  };

    this.handleFnameChange = this.handleFnameChange.bind(this);
    this.handleSnameChange = this.handleSnameChange.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleFnameChange(event) {
    this.setState({fname: event.target.value});
  }

  handleSnameChange(event) {
    this.setState({sname: event.target.value});
  }

  handleNumberChange(event) {
    this.setState({number: event.target.value});
  }

  // Message send event handler
  handleSubmit(event) {
    // Prevent default
    event.preventDefault();
    let fname = this.state.fname;
    let sname = this.state.sname;
    let number = this.state.number;
    //let t_id = this.state.t_id;
    if (fname !== '' && sname !== '') {
      // call the sendTeam of TeamContainer throught the props
      this.props.sendPlayer(fname, sname, number);
    }
   
    // Clear inputs
    this.state.fname = "";    
    this.state.sname = "";  
    this.state.number = "";  
    //this.state.t_id = "";    
    this.refs.fname.value = null;
    this.refs.sname.value = null;
    this.refs.number.value = null;
  }
  
  render () {
    return (
      <div className={(this.props.formDisplay ? '' : 'hide-form')}>
        <div className="click-this" onClick={this.props.toggleForm}>
          <h3><strong>+</strong> Lisää pelaaja</h3>
        </div>
        <div className="team-inputs">
          <form onSubmit={this.handleSubmit}>
            <input type="text" ref="fname" value={this.state.fname} onChange={this.handleFnameChange} placeholder="Pelaajan etunimi" />
            <input type="text" ref="sname" value={this.state.sname} onChange={this.handleSnameChange} placeholder="Pelaajan sukunimi" />
            <input type="text" ref="number" value={this.state.number} onChange={this.handleNumberChange} placeholder="Pelaajan numero" /><br />
            <button type="submit" onClick={this.handleSubmit}>Tallenna</button>
          </form>
        </div>
      </div>
    )
  }
}

class PlayersContainer extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isLoaded: false,
      formDisplay: false,
      players: []
    };
    this.toggleForm = this.toggleForm.bind(this);
    this.sendPlayer = this.sendPlayer.bind(this);
  }

  toggleForm() {
    this.setState({
      formDisplay: !this.state.formDisplay
    });
  }

  getPlayers() {
    $.ajax({
      url: 'ajax/get_all_players.php',
      cache: false,
      dataType: 'json'
    }).done( (data) => {
        this.setState({players: data, isLoaded:true});
    }).fail( (jqXHR, textStatus, errorThrown) => {
        console.log(textStatus+":"+errorThrown);
    });
  }

  sendPlayer(fname, sname, number) {
    $.ajax({
      url: 'ajax/add_player.php',
      cache: false,
      method: 'post',
      dataType: 'json',
      data: {p_fname: fname, p_sname: sname, p_number: number}
    }).done( (data) => {
      console.log(data);
      this.setState({players: data, isLoaded:true});
      this.toggleForm();
    }).fail( (jqXHR, textStatus, errorThrown) => {
        console.log(textStatus+":"+errorThrown);
    });
  }

  componentDidMount() {
    this.getPlayers();
    //setInterval(this.getTeams, 5000);
  }

  render () {
    const { isLoaded, players } = this.state;
    if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div className="players-container">
        <Players players={this.state.players} />
        <PlayersFooter 
          sendPlayer={this.sendPlayer} 
          formDisplay={this.state.formDisplay}
          toggleForm={this.toggleForm} />
      </div>
      );
    }
  }
}

ReactDOM.render(
  <PlayersContainer />,
  document.getElementById('container')
);
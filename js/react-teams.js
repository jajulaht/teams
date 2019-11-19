class Row extends React.Component {
  render () {
    return (
          <li><a href={ 'players.php?t_id=' + this.props.t_id }><strong>{this.props.t_name}</strong> | Manageri: {this.props.t_mngr}</a></li>
    );
  }
}



class Teams extends React.Component {
  render () {  
    // Loop through the list of teams and create array of Row components
    let Rows = this.props.teams.map(function(team, index) {
      return (
        <Row key={index} t_id={team.t_id} t_name={team.t_name} t_mngr={team.t_mngr} />
      )
    });
    
    return (
        <ul>
          {Rows}
        </ul>
    );
  }
}

class TeamsFooter extends React.Component {
  constructor(props) {
    super(props);
    this.state = {team: '',
                  mngr: ''};

    this.handleTeamChange = this.handleTeamChange.bind(this);
    this.handleMngrChange = this.handleMngrChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleTeamChange(event) {
    this.setState({team: event.target.value});
  }

  handleMngrChange(event) {
    this.setState({mngr: event.target.value});
  }

  // Message send event handler
  handleSubmit(event) {
    // Prevent default
    event.preventDefault();
    let team = this.state.team;
    let mngr = this.state.mngr;
    if (team !== '' && mngr !== '') {
      // call the sendTeam of TeamContainer throught the props
      this.props.sendTeam(team, mngr);
    }
   
    // Clear inputs
    this.state.team = "";    
    this.state.mngr = "";    
    this.refs.team.value = null;
    this.refs.mngr.value = null;
  }
  
  render () {
    return (
      <div className={(this.props.formDisplay ? '' : 'hide-form')}>
        <div className="click-this" onClick={this.props.toggleForm}>
          <h3><strong>+</strong> Lisää joukkue</h3>
        </div>
        <div className="team-inputs">
          <form onSubmit={this.handleSubmit}>
            <input type="text" ref="team" value={this.state.team} onChange={this.handleTeamChange} placeholder="Joukkueen nimi" />
            <input type="text" ref="mngr" value={this.state.mngr} onChange={this.handleMngrChange} placeholder="Managerin nimi" /><br />
            <button type="submit" ref="mngr" onClick={this.handleSubmit}>Tallenna</button>
          </form>
        </div>
      </div>
    )
  }
}

class TeamsContainer extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isLoaded: false,
      formDisplay: false,
      teams: []
    };
    this.toggleForm = this.toggleForm.bind(this);
    this.sendTeam = this.sendTeam.bind(this);
  }

  toggleForm() {
    console.log("Hep");
    this.setState({
      formDisplay: !this.state.formDisplay
    });
  }

  getTeams() {
    $.ajax({
      url: 'ajax/get_all_teams.php',
      cache: false,
      dataType: 'json'
    }).done( (data) => {
        this.setState({teams: data, isLoaded:true});
    }).fail( (jqXHR, textStatus, errorThrown) => {
        console.log(textStatus+":"+errorThrown);
    });
  }
  
/* data
Type: PlainObject or String or Array
Data to be sent to the server. It is converted to a query string, if not already a string. It's appended to the url for GET-requests. See processData option to prevent this automatic processing. Object must be Key/Value pairs. If value is an Array, jQuery serializes multiple values with same key based on the value of the traditional setting (described below). */

/*
sendTeam(team, mngr) {
  var me = this;
  $.ajax({
    url: 'ajax/add_team.php',
    cache: false,
    method: 'post',
    dataType: 'json',
    data: {t_name: team, t_mngr: mngr}
  }).done( function(data) {
    console.log(data);
    me.setState({teams: data, isLoaded:true});
  }).fail( function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus+":"+errorThrown);
  });
}
*/

  sendTeam(team, mngr) {
    $.ajax({
      url: 'ajax/add_team.php',
      cache: false,
      method: 'post',
      dataType: 'json',
      data: {t_name: team, t_mngr: mngr}
    }).done( (data) => {
      console.log(data);
      this.setState({teams: data, isLoaded:true});
      this.toggleForm();
    }).fail( (jqXHR, textStatus, errorThrown) => {
        console.log(textStatus+":"+errorThrown);
    });
  }

  componentDidMount() {
    this.getTeams();
    //setInterval(this.getTeams, 5000);
  }

  render () {
    const { isLoaded, teams } = this.state;
    if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div className="teams-container">
        <Teams teams={this.state.teams} />
        <TeamsFooter 
          sendTeam={this.sendTeam} 
          formDisplay={this.state.formDisplay}
          toggleForm={this.toggleForm} />
      </div>
      );
    }
  }
}

ReactDOM.render(
  <TeamsContainer />,
  document.getElementById('container')
);
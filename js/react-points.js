class Row extends React.Component {
  render () {
    return (
          <li><a href="#"><span className="goals">{this.props.goals}</span> | <strong>{this.props.sname}, {this.props.fname},</strong> {this.props.number}, {this.props.team}</a></li>
    );
  }
}

class Players extends React.Component {
  render () {  
    // Loop through the list of players and create array of Row components
    let Rows = this.props.players.map(function(player, index) {
      return (
        <Row key={index} sname={player.p_sname} fname={player.p_fname} number={player.p_number} goals={player.p_goals} team={player.t_name}  />
      )
    });
    
    return (
        <ul>
          {Rows}
        </ul>
    );
  }
}

class PlayersContainer extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isLoaded: false,
      players: []
    };
  }


  getPlayers() {
    $.ajax({
      url: 'ajax/get_all_playersG.php',
      cache: false,
      dataType: 'json'
    }).done( (data) => {
        this.setState({players: data, isLoaded:true});
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
      </div>
      );
    }
  }
}

ReactDOM.render(
  <PlayersContainer />,
  document.getElementById('container')
);
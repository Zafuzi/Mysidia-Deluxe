class Game.Soundtrack extends Backbone.Model
  TRACK_DELAY: 10
  defaultVol: 0.4

  defaults:
    songs: [ #each row should be changed to array containing mp3, ogg, wav for each file...
      '08-BlueSkiesAndRedShoes.mp3',
      'mix_n_match.mp3',
      'Soft-Chip.mp3'
    ]
    isPlaying: false
    directory: '/assets/'
    currentSong: null
    muted: false
    volume: 0.4

  initialize: ->
    @set('count', @get('songs').length)
    @_chooseRandomSong() unless @get('currentSong')?
    @_loadTrack()

    if Game.settings.isSoundMuted()
      Crafty.audio.mute()
      @set('muted', true)


  start: ->
    @play()
    @_startLoading()

  next: ->
    Crafty.audio.stop(@_trackName())
    @playNextRandomTrack()

  playNextRandomTrack: ->
    @_chooseRandomSong()
    @play()

  play: ->
    Crafty.audio.play(@_trackName(), 1, @get('volume'))
    @_currentTrack().addEventListener "ended", _.once =>
      setTimeout((=> @playNextRandomTrack()), @TRACK_DELAY)
    @set('isPlaying': true)

  toggleMute: ->
    Crafty.audio.toggleMute()
    @set('muted', Crafty.audio.muted)

  volume: (vol = @defaultVol) ->
    return if @get('muted')
    @set('volume', vol)
    @_currentTrack().volume = vol

  lowVol: -> @volume(0.1)


  _chooseRandomSong: ->
    @set('currentSong', _.sample(@_allOtherTrackIdxs()))

  _allOtherTrackIdxs: ->
    _.without(_.range(@get('count')), @get('currentSong'))

  _trackName: (id = @get('currentSong')) ->
    "track#{id}"

  _trackPaths: (id = @get('currentSong')) ->
    src = _.flatten([@get('songs')[id]])
    _.map(src, (filename) => "#{@get('directory')}#{@_pickFormat(filename)}")

  _loadTrack: (id = @get('currentSong')) ->
    Crafty.audio.add(@_trackName(id), @_trackPaths(id))

  _pickFormat: (file) ->
    if Modernizr.audio.ogg
      file.replace('mp3', 'ogg')
    else
      file

  _startLoading: ->
    ids = @_allOtherTrackIdxs()
    _.each ids, (id) =>
      @_loadTrack(id)

  _currentTrack: ->
    Crafty.audio.sounds[@_trackName()].obj
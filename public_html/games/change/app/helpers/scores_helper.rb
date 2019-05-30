module ScoresHelper
  SALT = 'mmm...salty'
  def identicon(id)
    md5 = Digest::MD5.hexdigest(id.to_s)
    image_tag "http://vanillicon.com/#{md5}.png"
  end
end
